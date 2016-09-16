#!/bin/bash
base=/home/www/docs.larastars.cn
docs=${base}/resources/docs/en
origin=https://github.com/laravel/docs

refresh()
{
  version=$1
  echo ${version}
  rm -rf ${docs}/${version} && cd ${docs}/ && git clone ${origin} -b ${version} ${version} && cd ${version} && sed -i "s/\/docs\/{{version}}/\/{{language}}\/{{version}}/g" `ls`
}

# cd ${docs}/5.0 && git pull origin 5.0
# cd ${docs}/5.1 && git pull origin 5.1
# cd ${docs}/5.2 && git pull origin 5.2
refresh 5.3
# cd ${docs}/master && git pull origin master

cd $base && php artisan docs:clear-cache