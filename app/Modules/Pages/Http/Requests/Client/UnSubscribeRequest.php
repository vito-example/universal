<?php

namespace App\Modules\Pages\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Post(
 *      path="/api/v1/subscribe/disable",
 *      operationId="subscribeDisable",
 *      tags={"Subscribe"},
 *      summary="Subscribe Disable",
 *      description="Subscribe Disable",
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
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(
 *              @OA\Property(property="message",type="string", example="Registration Successfully Message"),
 *          )
 *       ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(
 *              required={"email"},
 *              type="object",
 *              @OA\Property(
 *                  property="email",
 *                  type="string",
 *                  description="Email"
 *              )
 *          )
 *      )
 *   ),
 *   @OA\Response(
 *      response=422,
 *      description="Validation error",
 *      @OA\JsonContent(
 *              @OA\Property(property="message",type="string", example="The given data was invalid."),
 *              @OA\Property(
 *                  property="errors",
 *                  type="object",
 *                  description="Errors List",
 *                  @OA\Property(
 *                      property="email",
 *                      type="array",
 *                      @OA\Items(
 *                          type="string",
 *                          description="Field Error Texts"
 *                      )
 *                  )
 *              ),
 *      )
 *   ),
 *   @OA\Response(response=403, description="Resource Not Found", @OA\JsonContent(
 *      @OA\Property(property="code",type="integer", example="403"),
 *      @OA\Property(property="message",type="string", example="Invalid Credentials")
 *   )
 *  ),
 *   @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent(ref="#/components/schemas/resourceNotFound")),
 *   @OA\Response(response=500, description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/serverError"))
 * )
 */
class UnSubscribeRequest extends FormRequest
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
            'email'         => ['required','email','exists:subscribers,email'],
        ];
    }
}
