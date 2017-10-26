#!/bin/bash
base=$(pwd)
docs=${base}/resources/docs/en
origin=https://github.com/laravel/docs

refresh()
{
  version=$1
  rm -rf ${docs}/${version} && cd ${docs}/ && git clone ${origin} -b ${version} ${version} && cd ${version} && sed -ig "s/\/docs\/{{version}}/\/{{language}}\/{{version}}/g" `ls`
}

refresh 5.5
refresh master

cd $base && /usr/local/bin/php artisan docs:clear-cache
