<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Author;

use Illuminate\Http\Request;
use NilPortugues\Api\JsonApi\Http\Factory\RequestFactory;
use NilPortugues\Api\JsonApi\Server\Actions\ListResource;
use NilPortugues\Laravel5\JsonApi\Controller\JsonApiController;
use NilPortugues\Laravel5\JsonApi\Eloquent\EloquentHelper;

class AuthorsController extends JsonApiController
{
    /**
     * Return the Eloquent model that will be used
     * to model the JSON API resources.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getDataModel()
    {
        return new Author();
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getBooksByAuthor(Request $request)
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
            $id = (new Book())->getKeyName();
            return Book::query()
                ->where('author_id', '=', $request->author_id)
                ->get([$id])
                ->count();
        };

        $results = function()  use ($request) {
            return EloquentHelper::paginate(
                $this->serializer,
                Book::query()
                    ->where('author_id', '=', $request->author_id)
            )->get();
        };

        $uri = route('api.authors.books', ['author_id' => $request->author_id]);

        return $resource->get($totalAmount, $results, $uri, Author::class);
    }

}