#!/bin/bash  

# 只是方便分发二进制文件, 重启手动

path="/home/admin/banban"
targetPath="/home/webroot/gateway"
logPath="/home/log"

if [ ! -d "$targetPath" ]; then
	mkdir -p "$targetPath"
fi

if [ ! -d "$logPath" ]; then
	mkdir -p "$logPath"
fi

cp -f "${path}/bin/cmd" "${targetPath}/cmd"
cp -f "${path}/deploy/rpc.gateway.partying.conf" "/etc/supervisor/conf.d/rpc.gateway.conf"

echo "ok"
exit 0


