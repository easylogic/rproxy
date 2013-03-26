rproxy
======

Reverse Proxy Manager For Developers

## 개요 

각자가 원하는 호스트를 관리할 수 있는 사이트이다. 

## TODO List

1. 로그인 (twitter, facebook, tumblr, g+) 
2. 유저별 호스트 관리 
3. 유저별 호스트 공유 
4. 글로벌 호스트 공유 
5. 그룹 생성, 가입 
6. 그룹별 호스트 관리 
7. open api 제공 
8. 공유된 호스트 복제, 합치기(중복 합치기 제한) 
9. 호스트 파일로 출력 

## 타입 

1. 도메인 => URL 
``` www.test.com => www.test.com/testdir  ```
2. 도메인 => 도메인 (최초 접속 도메인 유지) 
``` www.test.com => www.test2.com ``` 
3. 패턴 비교 
``` www\.(test|test2|test3)\.com => www.dev.com/$1 ```

* 도메인 유지 옵션이 필요함 

## 우선순위 

1. 정규식 
2. 도메인 

## Site

http://rproxy.easylogic.co.kr
