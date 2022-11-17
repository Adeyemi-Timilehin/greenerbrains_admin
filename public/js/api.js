const API = {
    jwt: localStorage.getItem("jwt"),

    isLoggedIn() {
        return !!this.jwt;
    },

    /**
     * The default options to use with fetching API calls
     * @return {Object}
     */
    headers(contentType) {
        const headers = {
            Accept: "application/json",
        };

        if (this.jwt) {
            headers.Authorization = `Bearer ${this.jwt}`;
        }

        if (contentType) {
            headers["Content-Type"] = contentType;
        }

        return headers;
    },

    async getJson(url) {
        const opts = {
            method: "GET",
            headers: this.headers(),
        };

        let data = await fetch(url, opts).then((res) => {
            if (!res.ok) {
                throw new Error(res.status);
            }
            console.log(res.body.json());
            return res.json();
        });
    },

    async getAxios(url) {
        const opts = {
            method: "GET",
            headers: this.headers(),
        };

        return new Promise((resolve, reject) => {
            axios
                .get(url, opts)
                .then((resp) => {
                    let { data } = resp.data;
                    resolve(data);
                })
                .catch((e) => {
                    reject(e);
                });
        });
    },

    postJson(url, data) {
        const opts = {
            method: "POST",
            headers: this.headers("application/json"),
            // headers: this.headers("multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)),
            body: JSON.stringify(data),
        };

        return fetch(url, opts).then((res) => {
            if (!res.ok) {
                throw new Error(res.status);
            }

            return res.json();
        });
    },

    postFormData(url, data) {
        const opts = {
            method: "POST",
            headers: this.headers("application/json"),
            body: data,
        };

        return fetch(url, opts).then((res) => {
            if (!res.ok) {
                throw new Error(res.status);
            }

            return res.json();
        });
    },

    putJson(url, data) {
        const opts = {
            method: "PUT",
            headers: this.headers("application/json"),
            body: JSON.stringify(data),
        };

        return fetch(url, opts).then((res) => {
            if (!res.ok) {
                throw new Error(res.status);
            }

            return res.json();
        });
    },

    patchJson(url, data) {
        const opts = {
            method: "PATCH",
            headers: this.headers("application/json"),
            body: JSON.stringify(data),
        };

        return fetch(url, opts).then((res) => {
            if (!res.ok) {
                throw new Error(res.status);
            }

            return res.json();
        });
    },

    delete(url) {
        const opts = {
            method: "DELETE",
            headers: this.headers(),
        };

        return fetch(url, opts).then((res) => {
            if (!res.ok) {
                throw new Error(res.status);
            }
        });
    },

    loadImage(url) {
        const opts = {
            headers: {
                Authorization: `Bearer ${this.jwt}`,
            },
            cache: "reload",
        };

        return fetch(url, opts).then((res) => {
            if (!res.ok) {
                throw new Error(res.status);
            }

            return res.blob();
        });
    },

    userCount() {
        return this.getJson("/users/count")
            .then((body) => {
                return body.count;
            })
            .catch(() => {
                throw new Error("Failed to get user count.");
            });
    },

    assertJWT() {
        if (!this.jwt) {
            throw new Error("No JWT go login..");
        }
    },

    verifyJWT() {
        return fetch("/things", {
            headers: this.headers(),
        }).then((res) => res.ok);
    },

    createUser(name, email, password, user_type) {
        return this.postJson("/api/v1/register", {
            name,
            email,
            password,
            user_type,
        })
            .then((body) => {
                let { data, meta } = body;
                this.loadProfile(data);
                if (meta.hasOwnProperty("token")) {
                    let jwt = meta.token;
                    localStorage.setItem("jwt", jwt);
                    API.jwt = jwt;
                    return;
                }
            })
            .catch(() => {
                throw new Error("Repeating signup not permitted");
            });
    },

    getUser(id) {
        return this.getJson(`/api/v1/user/${encodeURIComponent(id)}`);
    },

    addUser(name, email, password) {
        return this.postJson("/users", {
            name,
            email,
            password,
        });
    },

    editUser(id, name, email, password, newPassword) {
        return this.putJson(`/users/${encodeURIComponent(id)}`, {
            id,
            name,
            email,
            password,
            newPassword,
        });
    },

    deleteUser(id) {
        return this.delete(`/users/${encodeURIComponent(id)}`);
    },

    getAllUserInfo() {
        return this.getJson("/users/info");
    },

    validateEmail(email) {
        let errorMessage = null;
        const regex = /\S+@\S+\.\S+/;
        const trimmedEmail = email.trim();

        if (trimmedEmail.length > 40) {
            errorMessage =
                "* Email is too long, please use shorter email address";
        }

        if (!regex.test(trimmedEmail) || trimmedEmail.length === 0) {
            errorMessage = "* Email must be in valid format";
        }

        if (errorMessage) {
            return false;
        } else {
            return true;
        }
    },

    changePassword(old_password, new_password, confirm_new_password) {
        return new Promise((resolve, reject) => {
            let data = this.postJson("/api/v1/change_password", {
                old_password,
                new_password,
                confirm_new_password,
            })
                .then((res) => {
                    if (res) {
                        resolve(res);
                    }
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },

    resetPasswordRequest(email) {
        return new Promise((resolve, reject) => {
            let data = this.postJson("/api/v1/reset_password", {
                email: email,
            })
                .then((res) => {
                    resolve(res);
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },

    login(email, password) {
        return this.postJson("/api/v1/login", {
            email,
            password,
        })
            .then((body) => {
                let { data, meta } = body;
                console.log(JSON.stringify(data));
                this.loadProfile(data);
                if (meta.hasOwnProperty("token")) {
                    let jwt = meta.token;
                    localStorage.setItem("jwt", jwt);
                    API.jwt = jwt;
                    return;
                }
            })
            .catch(() => {
                throw new Error("Incorrect username or password");
            });
    },

    logout() {
        this.assertJWT();
        localStorage.removeItem("email");
        localStorage.removeItem("id");
        localStorage.removeItem("jwt");
        localStorage.removeItem("name");
        localStorage.removeItem("status");
        localStorage.removeItem("subscribed_subjects");
        localStorage.removeItem("type");
        localStorage.removeItem("verified");
        localStorage.removeItem("init_time");
        window.location.href = "/admin/auth/login";
        return this.postJson("/api/v1/logout", {}).catch(() => {
            console.error("Logout failed...");
        });
    },

    loadProfile(user_object) {
        if ((user_object && typeof user_object == "Object") || "Array") {
            let keys = Object.keys(user_object);
            keys.forEach((key) => {
                localStorage.setItem(key + "", user_object[key]);
            });
            return;
        }
        return;
    },

    async loadCategories() {
        return new Promise((resolve, reject) => {
            return this.getAxios("/api/v1/categories")
                .then((r) => {
                    this.categories = r;
                    setTimeout(() => {
                        resolve(r);
                    }, 100);
                })
                .catch(() => {
                    console.error("Failed loading resources...");
                });
        });
    },
    async loadContentTypes() {
        return this.getAxios("/api/v1/content_types")
            .then((r) => {
                this.content_types = r;
                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        resolve(r);
                    }, 100);
                });
            })
            .catch(() => {
                console.error("Failed loading resources...");
            });
    },
    async loadAccessTypes() {
        return this.getAxios("/api/v1/content_accesses")
            .then((r) => {
                this.content_accesses = r;
                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        resolve(r);
                    }, 100);
                });
            })
            .catch(() => {
                console.error("Failed loading resources...");
            });
    },

    async loadContents() {
        return this.getAxios("/api/v1/contents")
            .then((r) => {
                this.contents = r;
                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        resolve(r);
                    }, 100);
                });
            })
            .catch((e) => {
                console.error("Failed loading resources..." + e);
            });
    },
};

// Elevate this to the window level.
window.API = API;
