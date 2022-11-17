<div class="kt-sideleft">
  <label class="kt-sidebar-label">Navigation</label>
  <ul class="nav kt-sideleft-menu">
    <li class="nav-item">
      <a href="{{ route('dashboard') }}" class="nav-link">
        <i class="icon ion-ios-home-outline"></i>
        <span>Dashboard</span>
      </a>
    </li>
    
       <!--nav-item for student-->
        <li class="nav-item" id="subject">
      <a href="#" class="nav-link with-sub">
        <i class="icon ion-university"></i>

        <span>Students</span>
      </a>
      <ul class="nav-sub">
        <li class="nav-item">
          <a href="{{ route('student') }}" class="nav-link">View Students</a>
        </li>
      </ul>
    </li>
    
    <!-- nav-item -->
    <li class="nav-item" id="subject">
      <a href="#" class="nav-link with-sub">
        <i class="icon ion-ios-briefcase"></i>

        <span>Subjects</span>
      </a>
      <ul class="nav-sub">
        <li class="nav-item">
          <a href="{{ route('subject') }}" class="nav-link">All Subjects</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('add-subject') }}" class="nav-link">Add New</a>
        </li>
      </ul>
    </li>
 
    
    <!-- nav-item -->
    <li class="nav-item" id="content-category">
      <a href="#" class="nav-link with-sub">
        <i class="icon ion-ios-list-outline"></i>
        <span>Content Manager</span>
      </a>
      <ul class="nav-sub">
        <li class="nav-item">
          <a href="{{ route('content') }}" class="nav-link">View All</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('add-content') }}" class="nav-link">Add New</a>
        </li>
      </ul>
    </li>

    <!-- nav-item -->
    <li class="nav-item" id="posts">
      <a href="#" class="nav-link with-sub">
        <i class="fa fa-edit"></i>

        <span>Blog Post</span>
      </a>
      <ul class="nav-sub">
        <li class="nav-item">
          <a href="{{ route('post.index') }}" class="nav-link">All Post</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('post.create') }}" class="nav-link">Add New</a>
        </li>
      </ul>
    </li>
    <!-- nav-item -->
    <!-- nav-item -->
    <li class="nav-item" id="content-category">
      <a href="#" class="nav-link with-sub">
        <i class="icon ion-ios-box-outline"></i>
        <span>Categories</span>
      </a>
      <ul class="nav-sub">
        <li class="nav-item">
          <a href="{{ route('category') }}" class="nav-link">View All</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('add-category') }}" class="nav-link">Add New</a>
        </li>
      </ul>
    </li>
    <!-- nav-item -->
    <!-- nav-item -->
    <li class="nav-item" id="tag">
      <a href="#" class="nav-link with-sub">
        <i class="fa fa-tag"></i>

        <span>Tags</span>
      </a>
      <ul class="nav-sub">
        <li class="nav-item">
          <a href="{{ route('tag') }}" class="nav-link">All Tags</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('add-tag') }}" class="nav-link">Add New</a>
        </li>
      </ul>
    </li>
    <!-- nav-item -->
    <li class="nav-item">
      <a href="/admin/messages" class="nav-link">
        <i class="icon ion-ios-filing-outline"></i>
        <span>Inbox</span>
      </a>
    </li>
    <!-- nav-item -->
    <li class="nav-item">
      <a href="/admin/reviews" class="nav-link">
        <i class="icon ion-star"></i>
        <span>Feedbacks</span>
      </a>
    </li>
    <!-- nav-item -->
    <li class="nav-item">
      <a href="/admin/profile" class="nav-link">
        <i class="icon ion-ios-person-outline"></i>
        <span>Profile</span>
      </a>
    </li>
    <!-- nav-item -->
    <li class="nav-item">
      <a href="{{ route('change-password') }}" class="nav-link">
        <i class="icon ion-key"></i>
        <span>Password Change</span>
      </a>
    </li>
    <!-- nav-item -->
    <li class="nav-item" id="logout">
      <a href="{{ route('logout') }}" class="nav-link">
        <i class="icon ion-power"></i>
        <span>Logout</span>
      </a>
    </li>
    <!-- nav-item -->
  </ul>
</div>
<!-- kt-sideleft -->
<script>
  // Logout Handler
  let logout_btn = document.getElementById("logout");
  logout_btn
    ?
    logout_btn.addEventListener("click", e => {
      e.preventDefault();
      API.logout();
    }) :
    null;

</script>