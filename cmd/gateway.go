package main

import (
	"flag"
	"log"
	"time"

	//g "github.com/gin-gonic/gin"
	gateway "github.com/rpcxio/rpcx-gateway"
	"github.com/rpcxio/rpcx-gateway/gin"
	"github.com/smallnest/rpcx/client"
)

var (
	addr       = flag.String("addr", ":9981", "http server address")
	registry   = flag.String("registry", "127.0.0.1:8500", "registry address")
	group      = flag.String("group", "dev", "env group")
	basePath   = "/banban"
	failmode   = flag.Int("failmode", int(client.Failover), "failMode, Failover in default")
	selectMode = flag.Int("selectmode", int(client.RoundRobin), "selectMode, RoundRobin in default")
)

func main() {
	flag.Parse()

	d, err := createServiceDiscovery(*registry)
	if err != nil {
		log.Fatal(err)
	}

	//g.SetMode(g.ReleaseMode)

	httpServer := gin.New(*addr)

	options := client.DefaultOption
	options.Group = *group
	options.Heartbeat = true
	options.HeartbeatInterval = time.Second * 1
	options.GenBreaker = func() client.Breaker {
		return client.NewConsecCircuitBreaker(2, time.Second*2)
	}
	gw := gateway.NewGateway("/rpc/:servicePath/:serviceMethod", httpServer, d, client.FailMode(*failmode), client.SelectMode(*selectMode), options)

	httpServer.SetPing()
	gw.Serve()
}

func createServiceDiscovery(regAddr string) (client.ServiceDiscovery, error) {
	return client.NewConsulDiscoveryTemplate(basePath, []string{regAddr}, nil)
}
