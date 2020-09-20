#!/bin/bash
export VISUAL=nano
exec /usr/bin/supervisord -n -c /etc/supervisord.conf
