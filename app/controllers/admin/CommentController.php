<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index(){
        $comment = new Comment();

        $page = (request('page')) ? request('page') : 1;
        $limit = 5;
        $pagination = handlPagination($limit, $page, 'comments');

        $listComment = $comment->params(['c.*', 'u.username', 'u.full_name', 'p.name','p.slug'])->join('users u','c.user_id = u.id')->join('products p','c.product_id = p.id')->limit($limit, $pagination['start'])->get();

        return $this->view('admin.comment.index',['comments' => $listComment, 'page' => $page, 'total' => $pagination['total']]);
    }

    public function delete(){
        $result = [
            'error' => false,
            'success' => false,
        ];

        $id = request('id');

        if (!$id) {
            $result['error'] = true;
            echo json_encode($result);
            return;
        }

        $comment = new Comment();

        $comment->where('id',$id);
        $comment->delete();

        $result['success'] = true;
        echo json_encode($result);
        return;
    }
}