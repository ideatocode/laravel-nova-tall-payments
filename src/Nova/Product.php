<?php

namespace IdeaToCode\LaravelNovaTallPayments\Nova;

use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;

use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BooleanGroup;
use IdeaToCode\LaravelNovaTallPayments\Nova\Price;
use IdeaToCode\LaravelNovaTallPayments\Facades\Larapay;

class Product extends Resource
{
    public static $group = 'Billing';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \IdeaToCode\LaravelNovaTallPayments\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('Name')
                ->rules('required', 'max:255')
                ->asHtml(),
            Slug::make('Slug')
                ->hideFromIndex()
                ->from('Name')
                ->separator('-')
                ->rules('required', 'max:255')
                ->creationRules('unique:products,slug')
                ->updateRules('unique:products,slug,{{resourceId}}'),
            Trix::make('Description')
                ->rules('required'),
            Number::make('Order')
                ->default(0)
                ->sortable(),
            Boolean::make('Status')
                ->withMeta(["value" => 1]),

            BooleanGroup::make('Features')->options(Larapay::productFeatures()),
            HasMany::make('Prices', 'prices', Price::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}