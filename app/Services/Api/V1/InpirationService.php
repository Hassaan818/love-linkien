<?php

namespace App\Services\Api\V1;

use App\Models\Inspiration;
use App\Services\Service;
use Illuminate\Support\Arr;
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

        if ($data['gallery']) {
            $galleryPaths = [];
            foreach ($data['gallery'] as $file) {
                $imageFile = $file;
                $imageName = time() . '_image.' . $imageFile->getClientOriginalExtension();
                $imageFile->move('images/inspiration', $imageName);
                $galleryPaths[] = 'images/inspiration/' . $imageName;
            }
            $inspiration->gallery = json_encode($galleryPaths);
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

    public function updateInspiration($data, $userId, $slug)
    {
        $inspiration = Inspiration::where('user_id', $userId)->where('slug', $slug)->first();

        if (!$inspiration) {
            return $this->notFoundResponse(4004, 'Inspiration Not Found', []);
        }
        $oldName = $inspiration->name;
        $inspiration->name = $data['name'] ?? $inspiration->name;
        if (isset($data['name']) && $data['name'] !== $oldName) {
            $inspiration->slug = Str::slug($data['name']);
        }
        $inspiration->short_description = $data['short_description'] ?? $inspiration->short_description;
        $inspiration->notes = $data['notes'] ?? $inspiration->notes;

        if (isset($data['gallery'])) {
            $galleryPaths = [];
            foreach ($data['gallery'] as $file) {
                $imageFile = $file;
                $imageName = time() . '_image.' . $imageFile->getClientOriginalExtension();
                $imageFile->move('images/inspiration', $imageName);
                $galleryPaths[] = 'images/inspiration/' . $imageName;
            }
            $inspiration->gallery = json_encode($galleryPaths);
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

    public function deleteInspiration($userId, $slug)
    {
        $inspiration = Inspiration::where('user_id', $userId)->where('slug', $slug)->first();

        if (!$inspiration) {
            return $this->notFoundResponse(4004, 'Inspiration Not Found', []);
        }

        $inspiration->delete();
        if ($inspiration) {
            $this->response['code'] = 2000;
            $this->response['message'] = 'Inspiration Deleted Successfully';
            $this->response['data'] = [];
            return $this->response;
        }

        $this->response['code'] = 5000;
        $this->response['message'] = 'Inspiration not saved';
        $this->response['data'] = null;
        return $this->response;
    }

    private function notFoundResponse(int $code, string $message, array $data): array
    {
        $this->response['code'] = $code;
        $this->response['message'] = $message;
        $this->response['data'] = $data;
        return $this->response;
    }
}
