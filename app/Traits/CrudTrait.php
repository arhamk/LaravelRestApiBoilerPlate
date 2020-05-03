<?php
namespace App\Traits;
use Illuminate\Support\Str;
//use Validator;




trait CrudTrait{

    public function index(){
        return $this->getModel()->get();
    }

    public function getModel(){
        return new $this->model;
    }

    public function getRequest(){
        if(!isset($this->validation)){
            return request();
        }

        return resolve($this->validation);
    }

//    public function createSlug($title, $id = 0)
//    {
//        // Normalize the title
//        $slug = $this->str_slug($title);
//
//        // Get any that could possibly be related.
//        // This cuts the queries down by doing it once.
//        $allSlugs = $this->getRelatedSlugs($slug, $id);
//
//        // If we haven't used it before then we are all good.
//        if (! $allSlugs->contains('slug', $slug)){
//            return $slug;
//        }
//
//        // Just append numbers like a savage until we find not used.
//        for ($i = 1; $i <= 10; $i++) {
//            $newSlug = $slug.'-'.$i;
//            if (! $allSlugs->contains('slug', $newSlug)) {
//                return $newSlug;
//            }
//        }
//
//        throw new \Exception('Can not create a unique slug');
//    }


    public function insert()
    {
        $record = $this->getModel();
        $record->user_id = $this->getRequest()->user_id;
        $record->title = $this->getRequest()->title;
        $record->slug = Str::slug($this->getRequest()->title,'-');
        $record->bodt = $this->getRequest()->bodt;
//        echo '<pre>';
//        print_r($record->all());
//        exit;
        return $this->getModel()->create($record->toArray());
    }

    public function update(\Illuminate\Http\Request $request)
    {
//        dd($request->all()); exit;
        //dd($this->getRequest()->all());
        //dd($request->id);

        $model = $this->getModel()->find($request->id)->update($this->getRequest()->all());
        //$model->save();
        return $model;
    }
    public function delete(\Illuminate\Http\Request $request)
    {
        $model = $this->getModel()::findOrFail($request->id);
        $model->delete();
        return $model;
    }











}
