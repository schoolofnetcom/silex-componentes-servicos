<?php

namespace SON\Controllers;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PostsController extends AbstractDefaultController
{

    //admin/posts
    public function index(){
        dump("luiz carlos");
        $sql = "SELECT * FROM posts;";
        $posts = $this->db->fetchAll($sql);
        return $this->twig->render('posts/list.html.twig', [
            'posts' => $posts
        ]);
    }

    public function create(){
        return $this->twig->render('posts/create.html.twig');
    }

    public function store(Request $request){
        $data = $request->request->all();
        $this->db->insert('posts', [
            'title' => $data['title'],
            'content' => $data['content']
        ]);
        $url = $this->urlGenerator->generate('admin.posts.index');
        return new RedirectResponse($url);
    }

    public function edit($id){
        $sql = "SELECT * FROM posts WHERE id = ?;";
        $post = $this->db->fetchAssoc($sql, [$id]);
        if(!$post){
            throw new HttpException(404,"Post não encontrado!");
        }
        return $this->twig->render('posts/edit.html.twig', ['post' => $post]);
    }

    public function update(Request $request,$id){
        $sql = "SELECT * FROM posts WHERE id = ?;";
        $post = $this->db->fetchAssoc($sql, [$id]);
        if(!$post){
            throw new HttpException(404,"Post não encontrado!");
        }
        $data = $request->request->all();
        $this->db->update('posts', [
            'title' => $data['title'],
            'content' => $data['content']
        ], ['id' => $id]);
        $url = $this->urlGenerator->generate('admin.posts.index');
        return new RedirectResponse($url);
    }

    public function destroy($id){
        $sql = "SELECT * FROM posts WHERE id = ?;";
        $post = $this->db->fetchAssoc($sql, [$id]);
        if(!$post){
            throw new HttpException(404,"Post não encontrado!");
        }
        $this->db->delete('posts', ['id' => $id]);
        $url = $this->urlGenerator->generate('admin.posts.index');
        return new RedirectResponse($url);
    }
}