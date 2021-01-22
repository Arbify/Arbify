if [ -f "startup.log" ] && [ "`tail -1 startup.log`" == "success" ]
then
    echo "run entrypoint.sh"
    docker/arbify/entrypoint.sh
else
    echo "run upgrade.sh to init-config"
    docker/arbify/upgrade.sh
    touch startup.log
    echo success>>startup.log
    docker/arbify/entrypoint.sh
fi
