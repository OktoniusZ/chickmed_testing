<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    //define properti
    public $status;
    public $message;
    public $resource;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    
     public function __construct($status, $message, $resource)
     {
         parent::__construct($resource);
         $this->status  = $status;
         $this->message = $message;
     }
 
     /**
      * Transform the resource into an array.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return array
      */
     public function toArray($request)
     {
         return [
             'success'   => $this->status,
             'message'   => $this->message,
             'data'      => $this->resource,
         ];
     }
}
