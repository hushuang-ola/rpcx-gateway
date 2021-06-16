#!/bin/bash  

# 只是方便分发二进制文件，初次部署机器，需要更改supervisor最大打开文件数限制

path="/home/admin/banban"
targetPath="/home/webroot/gateway"
logPath="/home/log"

apt-get install supervisor -y

if [ ! -d "$targetPath" ]; then
	mkdir -p "$targetPath"
fi

if [ ! -d "$logPath" ]; then
	mkdir -p "$logPath"
fi

cp -f "${path}/bin/cmd" "${targetPath}/cmd"
cp -f "${path}/deploy/rpc.gateway.conf" "/etc/supervisor/conf.d/rpc.gateway.conf"

echo "ok"
exit 0


