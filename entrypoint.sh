#!/usr/bin/env bash
set -e

SERVE=0
break_loop=0

while [[ "$#" -gt 0 && ${break_loop} = 0 ]]; do
    key="$1"
    case ${key} in
        --serve)
        SERVE=1
        ;;
        --)
        break_loop=1
        ;;
        *)
        # unknown option
        ;;
    esac
    shift
done

eval "$@"
if [ ${SERVE} = 1 ]; then
    echo "Starting apache..."
    service apache2 start
fi