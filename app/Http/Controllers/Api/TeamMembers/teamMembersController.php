<?php

namespace App\Http\Controllers\Api\TeamMembers;

use App\Http\Controllers\Controller;
use App\Models\dashboard\TeamMembers\member;
use Illuminate\Http\Request;

class teamMembersController extends Controller
{
    public function index($lang, $limit)
    {
        $members = member::orderBy('id', 'desc');
        if ($limit > 0)
            $members = $members->paginate($limit);
        else {
            $members = $members->get();
        }

        $members = $members->map(function ($member) use ($lang) {
            $member_data = [];
            if ($lang == 'ar') {
                $member_data['id'] = $member->id;
                $member_data['name'] = $member->name_ar;
                $member_data['about'] = strip_tags($member->about_ar);
                $member_data['image'] = $member->image;
                $member_data['facebook'] = $member->facebook_link;
                $member_data['twitter'] = $member->twitter_link;
                $member_data['linkedin'] = $member->linkedin_link;
                $member_data['youtube'] = $member->youtube_link;
            } else {
                $member_data['id'] = $member->id;
                $member_data['name'] = $member->name_en;
                $member_data['about'] = strip_tags($member->about_en);
                $member_data['image'] = $member->image;
                $member_data['facebook'] = $member->facebook_link;
                $member_data['twitter'] = $member->twitter_link;
                $member_data['linkedin'] = $member->linkedin_link;
                $member_data['youtube'] = $member->youtube_link;
            }
            return $member_data;
        });

        return response()->json([
            'success' => trans('admin.data_fetched'),
            'data' => $members,
        ], 200);
    }

    public function single($lang, $id)
    {
        $members = member::where('id', $id)->get();
        $members = $members->map(function ($member) use ($lang) {
            $member_data = [];
            if ($lang == 'ar') {
                $member_data['name'] = $member->name_ar;
                $member_data['about'] = strip_tags($member->about_ar);
                $member_data['image'] = $member->image;
                $member_data['facebook'] = $member->facebook_link;
                $member_data['twitter'] = $member->twitter_link;
                $member_data['linkedin'] = $member->linkedin_link;
                $member_data['youtube'] = $member->youtube_link;
            } else {
                $member_data['name'] = $member->name_en;
                $member_data['about'] = strip_tags($member->about_en);
                $member_data['image'] = $member->image;
                $member_data['facebook'] = $member->facebook_link;
                $member_data['twitter'] = $member->twitter_link;
                $member_data['linkedin'] = $member->linkedin_link;
                $member_data['youtube'] = $member->youtube_link;
            }
            return $member_data;
        });

        return response()->json([
            'success' => trans('admin.data_fetched'),
            'data' => $members,
        ], 200);
    }
}
