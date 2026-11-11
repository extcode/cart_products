#!/usr/bin/env bash
#
# Runs the acceptance tests with codeception.
#
# Usage:
#   Build/Scripts/acceptance.sh [test] [additional codecept run arguments]
#
# The tests run in the "acceptance" suite, so the first argument can be a
# single Cest, e.g. "AddSimpleProductWithoutStockHandlingToCartCest".
#
# Requirements:
#   - firefox and geckodriver available in PATH
#   - php with pdo_sqlite
#
# The codeception RunProcess extension starts geckodriver and the php built-in
# webserver. Both are stopped when this script exits, even on failure.

source "$(dirname "${BASH_SOURCE[0]}")/common.sh"

requireBinary codecept

for tool in firefox geckodriver; do
    if ! command -v "${tool}" > /dev/null 2>&1; then
        echo "Missing \"${tool}\" in PATH, it is required for the acceptance tests." >&2
        exit 1
    fi
done

TESTS_PATH="${PROJECT_ROOT}/.build/public/typo3temp/var/tests"
mkdir -p \
    "${TESTS_PATH}/acceptance" \
    "${TESTS_PATH}/acceptance-logs" \
    "${TESTS_PATH}/acceptance-reports" \
    "${TESTS_PATH}/acceptance-sqlite-dbs"

export INSTANCE_PATH="${TESTS_PATH}/acceptance"

cleanup() {
    pkill -f "php -S 127.0.0.1:8080" || true
    pkill -f "geckodriver" || true
}
trap cleanup EXIT

runPhp "${BIN_DIR}/codecept" build
runPhp "${BIN_DIR}/codecept" run acceptance "$@"
