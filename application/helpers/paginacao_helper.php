<?php

/**
 * 
 * @author Mário César
 * @since 2.1.3
 * @version 2.0 (2.6.6)
 * 
 * @param string $url
 * @param int $numeroTotal
 * @param int $porPagina
 * @param int $uriSegment The pagination function automatically determines which segment of your URI contains the page number. If you need something different you can specify it.
 * @param int $numLinks The number of "digit" links you would like before and after the selected page number. For example, the number 2 will place two digits on either side, as in the example links at the very top of this page.
 * @param int $currentPage Define a pagina
 * 
 * @return string
 */
function getConfigPaginacao($url, $numeroTotal, $porPagina, $uriSegment, $numLinks = 3, $currentPage = null) {

    return array(
	'base_url' => $url,
	'total_rows' => $numeroTotal,
	'per_page' => $porPagina,
	'num_links' => $numLinks,
	'last_link' => '<li class="last"><i class="fa fa-angle-double-right"></i></li>',
	'first_link' => '<li class="first"><i class="fa fa-angle-double-left"></i></li>',
	'prev_link' => '<li class="prev"><i class="fa fa-angle-left"></i></li>',
	'next_link' => '<li class="next"><i class="fa fa-angle-right"></i></li>',
	'uri_segment' => $uriSegment,
	'anchor_class' => '',
        
	'full_tag_open' => '<ul class="pagination">',
	'full_tag_close' => '</ul>',
        
	'first_tag_open' => '<li>',
	'first_tag_close' => '</li>',
        
	'last_tag_open' => '<li>',
	'last_tag_close' => '</li>',
        
	'prev_tag_open' => '<li>',
	'prev_tag_close' => '</li>',
        
	'next_tag_open' => '<li>',
	'next_tag_close' => '</li>',
        
	'cur_tag_open' => '<li class="current">',
	'cur_tag_close' => '</li>',
        
	'num_tag_open' => '<li>',
	'num_tag_close' => '</li>',
        
	'use_page_numbers' => true,
	'first_url' => $url . '/1',
        'cur_page' => $currentPage
    );
}
