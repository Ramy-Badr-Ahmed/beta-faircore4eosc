<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

/**
 * App\Models\SoftwareHeritageRequest
 *
 * @property int $id
 * @property int $saveRequestId
 * @property string $originUrl
 * @property string $visitType
 * @property string $saveRequestDate
 * @property string $saveRequestStatus
 * @property string $saveTaskStatus
 * @property string|null $visitStatus
 * @property string|null $visitDate
 * @property int $loadingTaskId
 * @property array|null $swhIdList
 * @property array|null $contextualSwhIds
 * @property array|null $latexSnippets
 * @property int $isValid
 * @property int $hasConnectionError
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereContextualSwhIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereHasConnectionError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereIsValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereLatexSnippets($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereLoadingTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereOriginUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereSaveRequestDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereSaveRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereSaveRequestStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereSaveTaskStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereSwhIdList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereVisitDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereVisitStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereVisitType($value)
 * @property int|null $createdBy_id
 * @property-read \App\Models\User|null $createdBy
 * @method static \Illuminate\Database\Eloquent\Builder|SoftwareHeritageRequest whereCreatedById($value)
 * @mixin \Eloquent
 */
class SoftwareHeritageRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'swhIdList' => 'array',
        'contextualSwhIds' => 'array',
        'latexSnippets' => 'array'
    ];

    const CREATION_REQUEST_PROPERTIES = [
        'saveRequestId',
        'originUrl',
        'visitType',
        'saveRequestDate',
        'saveRequestStatus',
        'saveTaskStatus',
        'loadingTaskId',
    ];

    const CREATION_MASS_PROPERTIES = [
        'saveRequestId',
        'visitType',
        'saveRequestDate',
        'saveRequestStatus',
        'saveTaskStatus',
        'loadingTaskId',
        'originUrl',
        'createdBy_id',
        'created_at'
    ];

    const UPDATE_REQUEST_PROPERTIES = [
        'saveRequestStatus',
        'saveTaskStatus',
        'visitStatus',
        'visitDate',
        'latexSnippets',
        'swhIdList',
        'contextualSwhIds'
    ];

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @return BelongsTo
     */

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'createdBy_id');
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param $array
     * @param $properties
     * @return void
     */

    private function add2DB($array, $properties): void
    {
        foreach($properties as $property) {
            if($property==='saveRequestId'){
                $this->{$property} = $array['id'];
                continue;
            }
            $this->{$property} = $array[Str::snake($property)];
        }
        $this->createdBy_id = Auth::user()->id;
        $this->save();
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param $postData
     * @return void
     */

    public function populateFromPostForm($postData): void
    {
        $this->add2DB($postData, self::CREATION_REQUEST_PROPERTIES);
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param $massPostedData
     * @return bool
     */

    public static function massAssign($massPostedData): bool
    {
        $massAssignedData = [];

        array_walk($massPostedData,
            function($row, $idx, $creationProperties) use(&$massAssignedData) {

                $row["created_by_id"] = Auth::user()->id;
                $row["created_at"] = now();

                $massAssignedData[] = array_combine($creationProperties, $row);
            },
            self::CREATION_MASS_PROPERTIES);

        return self::insert($massAssignedData);
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param $array
     * @param $properties
     * @return void
     */

    private function updateInDB($array, $properties)
    {
        foreach($properties as $property) {

            if(array_key_exists('swh_id_list', $array )){

                $latexArray = self::defineLatexArray($array["contextual_swh_ids"]["Directory-Context"] ?? $array["contextual_swh_ids"]["Content-Context"], $array['origin_url']);

                $array = array_merge($array, $latexArray);
            }
            $this->update([$property => $array[Str::snake($property)]]);
        }
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param $apiData
     * @return void
     */

    public function updateFromCronGets($apiData)
    {
        $apiProperties = self::UPDATE_REQUEST_PROPERTIES;

        if(!array_key_exists('swh_id_list', $apiData )){
            array_pop($apiProperties);
            array_pop($apiProperties);
            array_pop($apiProperties);
        }
        $this->updateInDB($apiData, $apiProperties);
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param $swhid
     * @param $url
     * @return array
     */

    private static function defineLatexArray($swhid, $url): array{

        $Latex_Snippets_PROPERTIES = [
            'Supplement-Latex',
            'Macro-Latex',
            'Another-Latex',
        ];

        $string = view('latex-templates.latex-template')
            ->with('swhid', $swhid)
            ->with('url', $url)
            ->render();

        $string = str_replace(')', '}', str_replace('(', '{', $string));
        $latexArray = explode("\n", $string);

        array_pop($latexArray);

        return ["latex_snippets" => array_combine($Latex_Snippets_PROPERTIES, $latexArray)];
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param array $queryResult
     * @return Collection
     */

    public static function queryCollection(array $queryResult): Collection
    {
        $queryArray = [];
        foreach ($queryResult as $row){
            $queryArray = array_merge($queryArray, get_object_vars($row));
        }
        return new Collection($queryArray);
    }

}
