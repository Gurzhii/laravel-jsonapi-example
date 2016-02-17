<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Author;

use Illuminate\Http\Request;
use NilPortugues\Api\JsonApi\Http\Factory\RequestFactory;
use NilPortugues\Api\JsonApi\Server\Actions\ListResource;
use NilPortugues\Laravel5\JsonApi\Controller\JsonApiController;
use NilPortugues\Laravel5\JsonApi\Eloquent\EloquentHelper;

class BooksController extends JsonApiController
{
    /**
     * Return the Eloquent model that will be used
     * to model the JSON API resources.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getDataModel()
    {
        return new Book();
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAuthorByBook(Request $request)
    {
        $apiRequest = RequestFactory::create();
        $page = $apiRequest->getPage();

        if (!$page->size()) {
            $page->setSize(10); //Default elements per page
        }

        $resource = new ListResource(
            $this->serializer,
            $page,
            $apiRequest->getFields(),
            $apiRequest->getSort(),
            $apiRequest->getIncludedRelationships(),
            $apiRequest->getFilters()
        );

        $totalAmount = function() use ($request) {
            $id = (new Author())->getKeyName();
            return Author::query()
                ->where('id', '=', $request->author_id)
                ->get([$id])
                ->count();
        };

        $results = function()  use ($request) {
            return EloquentHelper::paginate(
                $this->serializer,
                Author::query()
                    ->where('id', '=', $request->author_id)
            )->get();
        };

        $uri = route('api.authors.show', ['id' => $request->author_id]);

        return $resource->get($totalAmount, $results, $uri, Author::class);
    }
}