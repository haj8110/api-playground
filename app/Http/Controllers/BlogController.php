<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Blogs",
 *     description="API Endpoints for managing blog posts"
 * )
 */
class BlogController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/blogs",
     *     tags={"Blogs"},
     *     summary="List all blog posts",
     *     @OA\Response(
     *         response=200,
     *         description="List of blogs"
     *     )
     * )
     */
    public function index()
    {
        return Blog::latest()->paginate(10);
    }

    /**
     * @OA\Post(
     *     path="/api/blogs",
     *     tags={"Blogs"},
     *     summary="Create a new blog post",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","content"},
     *             @OA\Property(property="title", type="string", example="My first blog"),
     *             @OA\Property(property="content", type="string", example="This is the content of the blog.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Blog created"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $blog = Blog::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => Auth::id(),
        ]);

        return response()->json($blog, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/blogs/{id}",
     *     tags={"Blogs"},
     *     summary="Get a single blog post",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Blog data"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Blog not found"
     *     )
     * )
     */
    public function show(Blog $blog)
    {
        return $blog;
    }

    /**
     * @OA\Put(
     *     path="/api/blogs/{id}",
     *     tags={"Blogs"},
     *     summary="Update a blog post",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","content"},
     *             @OA\Property(property="title", type="string", example="Updated title"),
     *             @OA\Property(property="content", type="string", example="Updated content")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Blog updated"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function update(Request $request, Blog $blog)
    {
        if (Auth::id() !== $blog->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $blog->update($request->only('title', 'content'));
        return $blog;
    }

    /**
     * @OA\Delete(
     *     path="/api/blogs/{id}",
     *     tags={"Blogs"},
     *     summary="Delete a blog post",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function destroy(Blog $blog)
    {
        if (Auth::id() !== $blog->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $blog->delete();
        return response()->json(null, 204);
    }
}
