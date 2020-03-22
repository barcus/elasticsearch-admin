<?php

namespace App\Manager;

use Symfony\Component\HttpClient\HttpClient;

class PaginatorManager
{
    public function paginate($paginate): array
    {
        $slice = 2;

        if (0 == $paginate['size']) {
            $paginate['pages'] = 0;
        } else {
            $paginate['pages'] = ceil($paginate['total'] / $paginate['size']);
        }

        $pagesSlice = [];
        $startPage = $paginate['page'] - $slice;
        if (0 >= $startPage) {
            $startPage = 1;
        }
        $endPage = $paginate['page'] + $slice;
        if ($paginate['pages'] < $endPage) {
            $endPage = $paginate['pages'];
        }
        for ($i=$startPage;$i<=$endPage;$i++) {
            $pagesSlice[] = $i;
        }
        $paginate['pages_slice'] = $pagesSlice;

        if (false == in_array(1, $paginate['pages_slice'])) {
            $paginate['first'] = 1;
        } else {
            $paginate['first'] = false;
        }

        if (false == in_array($paginate['pages'], $paginate['pages_slice'])) {
            $paginate['last'] = $paginate['pages'];
        } else {
            $paginate['last'] = false;
        }

        if (1 < $paginate['page']) {
            $paginate['previous'] = $paginate['page'] - 1;
        } else {
            $paginate['previous'] = false;
        }

        if ($paginate['pages'] > $paginate['page']) {
            $paginate['next'] = $paginate['page'] + 1;
        } else {
            $paginate['next'] = false;
        }

        return $paginate;
    }
}
