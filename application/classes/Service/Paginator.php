<?php


class Service_Paginator
{
    public function getPaginator(int $page, int $showPages, int $numPages): array
    {
        $downPages = floor(($showPages - 1) / 2);
        $upPages = ceil(($showPages - 1) / 2);

        $startPage = ($page - $downPages) > 0 ? ($page - $downPages) : 1;
        $addUpPages = (($page - 1) >= $downPages) ? 0 : ($downPages - ($page - 1));
        $endPage = ($page + $upPages) <= $numPages ? ($page + $upPages) : $numPages;
        $addDownPages = ($numPages - $page) < $upPages ? ($upPages - ($numPages - $page)) : 0;
        $freeUpPages = ($numPages - $page - $upPages) > 0 ? ($numPages - $page - $upPages) : 0;
        $freeDownPages = ($page - 1 - $downPages) > 0 ? ($page - 1 - $downPages) : 0;

        if ($addUpPages && $freeUpPages) {
            $endPage += $addUpPages >= $freeUpPages ? $freeUpPages : $addUpPages;
        }

        if ($addDownPages && $freeDownPages) {
            $startPage -= $addDownPages >= $freeDownPages ? $freeDownPages : $addDownPages;
        }

        return [
            'paginator' => range($startPage, $endPage),
            'prev' => ($startPage > 1) ? 1 : 0,
            'next' => ($endPage < $numPages) ? 1 : 0
        ];
    }
}
