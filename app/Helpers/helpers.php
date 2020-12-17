<?php

function presentPrice($price)
{
    return '$' . number_format($price / 100, 2);
}

function productImage($path)
{
    return $path && file_exists('storage/' . $path) ? asset('storage/' . $path) : asset('img/not-found.jpg');
}

function setActiveCategory($category)
{
    return $category == request()->category ? 'active' : '';
}
