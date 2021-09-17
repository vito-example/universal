<?php

namespace App\Modules\Pages\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Get(
 *      path="/api/v1/page",
 *      operationId="getPageIndex",
 *      tags={"Static Page"},
 *      summary="Page index data",
 *      description="Page index data",
 *     @OA\Parameter(
 *         name="locale",
 *         in="header",
 *         description="Locale",
 *         @OA\Schema(
 *              type="string",
 *              enum={"ka", "en", "ru"}
 *          ),
 *          required=true,
 *          example="ka"
 *     ),
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Page",
 *         @OA\Schema(
 *              type="string",
 *              enum={"provider","about", "home", "careers","news","gallery","faq", "404_not_found","privacy_policy","club_card", "jackpots","offers","terms_conditions"}
 *          ),
 *          required=true,
 *          example="ka"
 *     ),
 *     @OA\Parameter(
 *         name="modules[]",
 *         in="query",
 *         description="Module",
 *         @OA\Schema(
 *              type="array",
 *              @OA\Items(
 *              enum={
 *                  "privacy-policy",
 *                  "faq",
 *                  "gallery",
 *                  "news",
 *                  "about",
 *                  "about-contact",
 *                  "home",
 *                  "card-terms-conditions",
 *                  "card-benefits",
 *                  "card-info",
 *                  "seo",
 *                  "default-contact",
 *                  "terms-conditions",
 *                  "provider"
 *              }),
 *          ),
 *         required=true
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(
 *              @OA\Property(property="message",type="string", example="Get page info."),
 *              @OA\Property(
 *                  property="data",
 *                  type="object",
 *                  description="Response Data"
 *              )
 *          )
 *       ),
 *      @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent(ref="#/components/schemas/resourceNotFound")),
 *      @OA\Response(response=500, description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/serverError"))
 * )
 */
class PageIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
