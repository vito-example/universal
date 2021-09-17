<?php

namespace App\Modules\Pages\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Get(
 *      path="/api/v1/page/type",
 *      operationId="getPageTypeData",
 *      tags={"Static Page"},
 *      summary="Page type data",
 *     @OA\Parameter(
 *         name="path",
 *         in="query",
 *         description="Url Path",
 *         @OA\Schema(
 *              type="string"
 *          ),
 *          required=false
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
class PageTypeRequest extends FormRequest
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
        ];
    }
}
