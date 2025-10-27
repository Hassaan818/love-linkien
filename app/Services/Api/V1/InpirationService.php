<?php

namespace App\Services\Api\V1;

use App\Models\Inspiration;
use App\Services\Service;
use Illuminate\Support\Str;

class InpirationService extends Service
{
    public function getInpiration($userId)
    {
        if (!$userId) {
            $this->response['code'] = 4004;
            $this->response['message'] = 'User Not Found';
            $this->response['data'] = null;
            return $this->response;
        }

        $inspirations = Inspiration::where('user_id', $userId)->get();
        if ($inspirations) {
            $this->response['data'] = [
                'inspirations' => $inspirations
            ];
            $this->response['code'] = 2000;
            $this->response['message'] = "Inspirations Retrieved Successfully";
            return $this->response;
        }

        $this->response['code'] = 4000;
        $this->response['message'] = "No Inspirations Found";
        $this->response['data'] = null;
        return $this->response;
    }

    public function getInspiration($slug, $userId)
    {
        if (!$userId) {
            $this->response['code'] = 4004;
            $this->response['message'] = 'Please Login';
            $this->response['data'] = null;
            return $this->response;
        }
        if (!$slug) {
            $this->response['code'] = 4004;
            $this->response['message'] = 'Please Provide Slug';
            $this->response['data'] = null;
            return $this->response;
        }

        $inspiration = Inspiration::where('user_id', $userId)
            ->where('slug', $slug)->first();

        if ($inspiration) {
            $this->response['code'] = 2000;
            $this->response['message'] = 'Inspiration Retrieved Successfully';
            $this->response['data'] = [
                'inspiration' => $inspiration
            ];
            return $this->response;
        }

        $this->response['code'] = 4000;
        $this->response['message'] = 'Inpiration Not Found';
        $this->response['data'] = null;
        return $this->response;
    }

    public function storeInspiration($data, $userId)
    {
        if (!$userId) {
            $this->response['code'] = 4004;
            $this->response['message'] = 'Please Login';
            $this->response['data'] = null;
            return $this->response;
        }

        $inspiration = new Inspiration();
        $inspiration->name = $data['name'];
        $inspiration->slug = Str::slug($data['name']);
        $inspiration->notes = $data['notes'];
        $inspiration->short_description = $data['short_description'];
        $inspiration->user_id = $userId;

        if (isset($data['gallery'])) {
            $galleryPath = [];

            foreach ($data['gallery'] as $gallery) {
                $filename = time() . rand(1, 100) . '_' . str_replace(['"', "'"], "", $gallery->getClientOriginalName());
                $gallery->storeAs('media/inspirations', $filename, 'public');
                $galleryPath[] = $filename;
            }

            $inspiration->gallery = json_encode($galleryPath);
        }

        $inspiration->save();

        if ($inspiration) {
            $this->response['code'] = 2000;
            $this->response['message'] = 'Inspiration Saved Successfully';
            $this->response['data'] = [
                'inspiration' => $inspiration
            ];
            return $this->response;
        }

        $this->response['code'] = 5000;
        $this->response['message'] = 'Inspiration not saved';
        $this->response['data'] = null;
        return $this->response;
    }
}
