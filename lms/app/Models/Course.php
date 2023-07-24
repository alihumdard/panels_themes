<?php

namespace App\Models;

use DiUtil\Utilities\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Course extends Model
{
//    use HasFactory;

    protected $table = 'courses';

    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'is_enable',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    protected $tableColumnList = [
        'id'            => 'id',
        'title'         => 'title',
        'is_enable'     => 'is_enable',
        'created_by'    => 'created_by',
        'created_at'    => 'created_at',
        'updated_by'    => 'updated_by',
        'updated_at'    => 'updated_at',
    ];

    protected $otherColumnList = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Set column Name with Actual name.
     *
     * @param string $request
     * @return array
     */
    public function filterColumns(Request $request, $method = null)
    {
        if ($method == null) {
            $method = $request->method();
        }

        $columnList = $this->tableColumnList + $this->otherColumnList;

        Utilities::filterColumnsModel($request, $columnList, $method);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($request, $method = null)
    {
        if ($method == null) {
            $method = $request->method();
        }

        $rules = [];

        $rules = match ($method) {
            'POST' => [
                'title' => 'required',
            ],
            'PUT' => [
                'id' => 'required|integer',
                'name' => [
                    'required', Rule::unique('countries', 'country_name')->where(function ($query) use ($request) {
                        $query->where('is_enable', '<>', '2')
                            ->where('id', '<>', $request->id);
                    }),
                    'min:3', 'max:100' //'alpha_space',
                ],
                'full_name' => 'min:3|max:150', //alpha_space
                'dial_code' => 'required|numeric|digits_between:1,10',
                'short_code' => [
                    'required', Rule::unique('countries', 'short_code')->where(function ($query) use ($request) {
                        $query->where('is_enable', '<>', '2')
                            ->where('id', '<>', $request->id);
                    }),
                    'alpha', 'min:2', 'max:3'
                ],
                'short_code' => 'required|unique:countries,short_code,' . $request->id.'|alpha|min:2|max:3'
            ],
            'PATCH' => [
                'id' => 'required|integer',
                'activate' => 'required|numeric|between:0,1'
            ],
            'DELETE' => [
                'id' => 'required|integer',
            ],
            'GET_ONE' => [
                'id' => 'required|integer'
                // 'fields' => ''
            ],
            'GET_ALL' => [
                // 'fields' => ''
            ]
        };

        return $rules;
    }

    /**
     * Get the validation custom messages.
     *
     * @return array
     */
    public function messages($request, $method = null)
    {
        if ($method == null) {
            $method = $request->method();
        }

        $messages = [];

        $commonMessages = [
            'name.required' => [
                "code" => 10153,
                "message" => "Please provide course name."
            ],
            'name.unique' => [
                "code" => 10154,
                "message" => "Please provide unique country name."
            ],
            'name.alpha_space' => [
                "code" => 10155,
                "message" => "The country name may only contain letters and spaces."
            ],
            'name.min' => [
                "string" => [
                    "code" => 10156,
                    "message" => "The country name must be at least :min characters."
                ]
            ],
            'name.max' => [
                "string" => [
                    "code" => 10157,
                    "message" => "The country name may not be greater than :max characters."
                ]
            ],

            'full_name.alpha_space' => [
                "code" => 10158,
                "message" => "The country full name may only contain letters and spaces."
            ],
            'full_name.min' => [
                "string" => [
                    "code" => 10159,
                    "message" => "The country full name must be at least :min characters."
                ]
            ],
            'full_name.max' => [
                "string" => [
                    "code" => 10160,
                    "message" => "The country full name may not be greater than :max characters."
                ]
            ],

            'dial_code.required' => [
                "code" => 10161,
                "message" => "Please provide country dialing code."
            ],
            'dial_code.numeric' => [
                "code" => 10162,
                "message" => "The country code may only contain numbers."
            ],
            'dial_code.digits_between' => [
                "code" => 10163,
                "message" => "The country code must between 1 and 10 digits."
            ],

            'short_code.required' => [
                "code" => 10164,
                "message" => "Please provide country ISO code."
            ],
            'short_code.alpha' => [
                "code" => 10165,
                "message" => "The country ISO code may only contain letters."
            ],
            'short_code.min' => [
                "string" => [
                    "code" => 10166,
                    "message" => "The country ISO code must be at least :min characters."
                ]
            ],
            'short_code.max' => [
                "string" => [
                    "code" => 10167,
                    "message" => "The country ISO code may not be greater than :max characters."
                ]
            ],
            'short_code.unique' => [
                "code" => 10168,
                "message" => "Please provide unique country ISO code."
            ],

        ];

        $idMessages = [
            'id.required' => [
                "code" => 10169,
                "message" => "Please provide country id."
            ],
            'id.integer' => [
                "code" => 10170,
                "message" => "Id must be an integer."
            ]
        ];

        $statusMessage = [
            'activate.required' => [
                "code" => 10171,
                "message" => "Please provide activate flag."
            ],
            'activate.numeric' => [
                "code" => 10172,
                "message" => "Activate flag must be an integer."
            ],
            'activate.between' => [
                'numeric' => [
                    "code" => 10173,
                    "message" => "The activate flag must be between :min and :max."
                ]
            ]
        ];

        $messages = match ($method) {
            'POST' => $commonMessages,
            'PUT' => $commonMessages + $idMessages,
            'PATCH' => $idMessages + $statusMessage,
            'DELETE' => $idMessages,
            'GET_ONE' => $idMessages,
            'GET_ALL' => $messages = []
        };

        return $messages;
    }
}
