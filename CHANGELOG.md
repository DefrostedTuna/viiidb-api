# Changelog

All notable changes to this project will be documented in this file. See [standard-version](https://github.com/conventional-changelog/standard-version) for commit guidelines.

## [0.3.0](https://github.com/DefrostedTuna/viiidb-api/compare/0.2.7...0.3.0) (2022-04-13)


### ⚠ BREAKING CHANGES

* Searching via SQL using query parameters has been deprecated. The `search` and `{field}` query parameters on resource endpoints will no longer work moving forward. Please use the `/v{apiVersion}/search` endpoint instead in order to search through the various resources.

### Features

* add query param option descriptions to status endpoint ([#50](https://github.com/DefrostedTuna/viiidb-api/issues/50)) ([545af28](https://github.com/DefrostedTuna/viiidb-api/commit/545af28b4a5068fe0a02ede9f58463c1cc043b94))
* introduce meilisearch service via laravel scout ([#47](https://github.com/DefrostedTuna/viiidb-api/issues/47)) ([1144806](https://github.com/DefrostedTuna/viiidb-api/commit/1144806db63f05d4bad846d62825918f6f633b2a))


### refactor

* remove search and filter functionality from sql queries ([#48](https://github.com/DefrostedTuna/viiidb-api/issues/48)) ([fb930c6](https://github.com/DefrostedTuna/viiidb-api/commit/fb930c624739daaa47092fa8a6ce7184c8c972f6))

## [0.2.7](https://github.com/DefrostedTuna/viiidb-api/compare/0.2.6...0.2.7) (2021-10-05)


### Features

* add stat resource (API-11) ([#38](https://github.com/DefrostedTuna/viiidb-api/issues/38)) ([6f9bd87](https://github.com/DefrostedTuna/viiidb-api/commit/6f9bd87e6340c4c03ac1f0a0b64a894f644ca0c4))
* add element resource (API-5) ([#39](https://github.com/DefrostedTuna/viiidb-api/issues/39)) ([c057609](https://github.com/DefrostedTuna/viiidb-api/commit/c05760971a7053fc9149faa593d5d3e7c5797361))
* add sort_id to the status effect resource (API-85) ([#40](https://github.com/DefrostedTuna/viiidb-api/issues/40)) ([ab61295](https://github.com/DefrostedTuna/viiidb-api/commit/ab612958546c8590379e5491a152b5e6fc411a5b))

## [0.2.6](https://github.com/DefrostedTuna/viiidb-api/compare/0.2.5...0.2.6) (2021-09-22)


### Features

* add status effect resource (API-12) ([#33](https://github.com/DefrostedTuna/viiidb-api/issues/33)) ([b338809](https://github.com/DefrostedTuna/viiidb-api/commit/b338809ef51690d280887e4c1ad604e5fcfb5d41))

## [0.2.5](https://github.com/DefrostedTuna/viiidb-api/compare/0.2.4...0.2.5) (2021-09-20)


### Bug Fixes

* remove request analytics from status endpoint (API-81) ([#31](https://github.com/DefrostedTuna/viiidb-api/issues/31)) ([042aafa](https://github.com/DefrostedTuna/viiidb-api/commit/042aafa40fc293f471aea3f33781366e3d1e7426))

## [0.2.4](https://github.com/DefrostedTuna/viiidb-api/compare/0.2.3...0.2.4) (2021-09-20)


### Features

* add inbound request analytics (API-53) ([#27](https://github.com/DefrostedTuna/viiidb-api/issues/27)) ([5da56b9](https://github.com/DefrostedTuna/viiidb-api/commit/5da56b9afe8e81a6b9fa3477550eec40c19d625a))
* introduce exception monitoring via sentry (API-61) ([#26](https://github.com/DefrostedTuna/viiidb-api/issues/26)) ([9310359](https://github.com/DefrostedTuna/viiidb-api/commit/9310359b15d95159a1a8486d53d73cfa58b15677))


### Bug Fixes

* include timestamps when seeding the seed rank resource (API-74) ([#25](https://github.com/DefrostedTuna/viiidb-api/issues/25)) ([9b4ce85](https://github.com/DefrostedTuna/viiidb-api/commit/9b4ce85f623ec8033eb5edf9360635c4b4de0bdb))
* remove throttle middleware from status endpoint (API-80) ([#29](https://github.com/DefrostedTuna/viiidb-api/issues/29)) ([548d8ef](https://github.com/DefrostedTuna/viiidb-api/commit/548d8efa0a6fc82f5e0150d9a99a0e7310b7dd5f))

## [0.2.3](https://github.com/DefrostedTuna/viiidb-api/compare/0.2.2...0.2.3) (2021-08-30)


### Features

* add seed test resource (API-10) ([#20](https://github.com/DefrostedTuna/viiidb-api/issues/20)) ([6b21f80](https://github.com/DefrostedTuna/viiidb-api/commit/6b21f800138c12ebc1a18c1ac129097a56e23c2e))
* add test questions resource & relationship scaffolding (API-9) ([#21](https://github.com/DefrostedTuna/viiidb-api/issues/21)) ([0cae402](https://github.com/DefrostedTuna/viiidb-api/commit/0cae402f6071b1af6f493a2235f6c0db4dcca69f))

## [0.2.2](https://github.com/DefrostedTuna/viiidb-api/compare/0.2.1...0.2.2) (2021-08-27)


### Features

* allow records to be filtered by the value of a given field (API-67) ([#18](https://github.com/DefrostedTuna/viiidb-api/issues/18)) ([24d92e0](https://github.com/DefrostedTuna/viiidb-api/commit/24d92e0e1d80936e6f742cd954d6153e8603b1a9))

## [0.2.1](https://github.com/DefrostedTuna/viiidb-api/compare/0.2.0...0.2.1) (2021-08-22)


### Bug Fixes

* allow release containers to be built (API-71) ([#13](https://github.com/DefrostedTuna/viiidb-api/issues/13)) ([e2c2d70](https://github.com/DefrostedTuna/viiidb-api/commit/e2c2d7076b10e1b7b32b73eb0edc643fc2fbaab5))

## [0.2.0](https://github.com/DefrostedTuna/viiidb-api/compare/0.1.0...0.2.0) (2021-08-22)


### ⚠ BREAKING CHANGES

* The `/api` prefix for endpoints has been removed due to redundancy. Endpoints with the `/api` prefix will not longer work.

### Features

* add resources outline to status endpoint (API-68) ([#11](https://github.com/DefrostedTuna/viiidb-api/issues/11)) ([e0ac82a](https://github.com/DefrostedTuna/viiidb-api/commit/e0ac82a7a31501984f5157fa70a0b3a2c599d339))


### refactor

* remove `/api` prefix from endpoints ([#9](https://github.com/DefrostedTuna/viiidb-api/issues/9)) ([8c31742](https://github.com/DefrostedTuna/viiidb-api/commit/8c31742892cca4d676f512f2b79686581eca1692))

## [0.1.0](https://github.com/DefrostedTuna/viiidb-api/tree/0.1.0) (2021-08-22)

:tada: Initial release! :tada:

### Features

* add api versioning (API-4) ([#3](https://github.com/DefrostedTuna/viiidb-api/issues/3)) ([2d70624](https://github.com/DefrostedTuna/viiidb-api/commit/2d70624b19dfece679e993f0b581181d3f8fca07))
* add seed rank resource (API-8) ([#6](https://github.com/DefrostedTuna/viiidb-api/issues/6)) ([a8a3240](https://github.com/DefrostedTuna/viiidb-api/commit/a8a3240923dfc0513b2251d718f9f73c96e88723))
