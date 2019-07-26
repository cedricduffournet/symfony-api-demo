#!/bin/bash
while [ "$(docker inspect -f '{{.State.Health.Status}}' symfony-demo_db)" != "healthy" ];
do
    sleep 1
done