<?php

namespace App\Http\Resources;

use App\Category;
use App\ContentAccess;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;
use PHPUnit\Framework\Constraint\IsEmpty;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $category = Category::where('id', $this->category)->first();

        $content_access = ContentAccess::find($this->access);
        if(isset($content_access)) $content_access->first();

        // return parent::toArray($request);

        $result = [
            'id' => $this->id ? (string)$this->id : '',
            'name' => $this->name ? (string)$this->name : '',
            'label' => $this->label ? (string)$this->label : '',
            'price' => isset($this->price) ? $this->price : 0,
            'likes' => isset($this->likes) ? $this->likes : 3,
            'views' => isset($this->views) ? $this->views : 2,
            'description' => $this->description ? (string)$this->description : '',
            'language' => $this->language ? (string)$this->language : 'english',
            'summary' => $this->summary ? (string)$this->summary : '',
            'publisher_id' => $this->publisher_id ? $this->publisher_id : null,
            'rating' => isset($this->rating) ? $this->rating : 3,
            'category' => isset($category) ? (string)$category->label : "",
            'thumbnail' => $this->thumbnail ? (string)$this->thumbnail : null,
            'preview_video' => $this->preview_video ? (string)$this->preview_video : null,
            // 'access' => isset($content_access->name) ? $content_access->label : "",
            'access' => $this->access ? $this->access : "free",
            'contents' => $this->contents,
            'rating' => isset($this->rating) ? $this->rating : 3,                                                                                                                                                              
            'tags' => $this->tags ? $this->getTags($this->tags) : [],
            'publisher' => $this->publisher_id ? $this->getPublisher($this->publisher_id) : null,
            'categories' => $this->categories ? $this->getCategories($this->getCategories) : [],
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ] ;


        if(isset($result['tags']) && !count($result['tags'])) {
            unset($result['tags']);
        }
        return $result;
    }

    private function mapArray($arrayObject = [], $field = 'name') {
      if (gettype($arrayObject) !== 'array' || (gettype($arrayObject) === 'array' && count($arrayObject) < 1)) return $arrayObject;

      $request = [];
      foreach ($arrayObject as $key => $item) {
        array_push($request, $item[$field]);
      }
      return $request;
    }

    private function getPublisher($id = null) {
      if (!$id) {
        return $id;
      }

      $publisher = User::where('id', $id)->first();
      if(isset($publisher)) {
        return $publisher;
      }
    }

    private function getTags($tags){
        $result = [];
        if(isset($tags)){
            foreach ($tags as $key => $tag) {
                array_push($result, $tag->label);
            }
            return $result;
        }
        return $result;
    }

    private function getCategories($categories){
        $result = [];
        if(isset($categories)){
            foreach ($categories as $key => $category) {
                array_push($result, $category->label);
            }
            return $result;
        }
        return $result;
    }
}
