<?php
/**
 * Author : Denis-Florin Rendler
 * Date   : 13/10/15
 * Copyright (c) 2015 Denis-Florin Rendler <connect@rendler.me>
 */

namespace KoderHut\RssFeedster\Classes\Support\Adapters;

use KoderHut\RssFeedster\Classes\Contracts\IAdapter;

/**
 * Class BlogPostXmlAdapter
 * Adapter between the Posts data source and the XML renderer
 *
 * @package KoderHut\RssFeedster\Classes\Support\Adapters
 */
class BlogPostXmlAdapter
    implements IAdapter
{

    /**
     * Transform Post data into XML elements
     *
     * @param mixed $item
     * @param mixed $dataItem
     *
     * @return void
     */
    public function getDataValue($item, $dataItem)
    {
        switch ($item->tagName) {
            case 'title':
                $item->nodeValue = $dataItem->title;
            break;

            case 'link':
            case 'guid':
                $item->nodeValue = $dataItem->url;
            break;

            case 'pubDate':
                $item->nodeValue = $dataItem->published_at->format('r');
            break;

            case 'dc:creator':
                $creator = new \DOMCdataSection ($dataItem->user->full_name);
                $item->appendChild($creator);
            break;

            case 'category':

            break;

            case 'description':
                $description = new \DOMCdataSection($dataItem->summary);
                $item->appendChild($description);
            break;

            case 'content:encoded':
                $content = new \DOMCdataSection($dataItem->feed_content);
                $item->appendChild($content);
            break;

            case 'comments':
                $item->nodeValue = $dataItem->comments_url;
            break;

            default:
        }
    }
}