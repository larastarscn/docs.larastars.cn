#!/bin/bash
base=/home/www/docs.larastars.cn
docs=${base}/resources/docs/en
origin=https://github.com/laravel/docs

refresh()
{
  version=$1
  rm -rf ${docs}/${version} && cd ${docs}/ && git clone ${origin} -b ${version} ${version} && cd ${version} && sed -ig "s/\/docs\/{{version}}/\/{{language}}\/{{version}}/g" `ls`
}

refresh 5.3
refresh 5.4

cd $base && /usr/local/bin/php artisan docs:clear-cache
