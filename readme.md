<p>
    <h3>Deploy instruction</h3>
</p>
<p>
    <h4>Install start packages</h4>
    <div>
        sudo apt-get install make git curl libpng-dev
    </div>
</p>

<p>
    <h4>Php install</h4>
    <div>
        sudo apt install php7.2 php7.2-mysql php7.2-curl php7.2-json libapache2-mod-php7.2
    </div>
</p>

<p>
    <h4>Mysql setup</h4>
    <div>
        sudo apt install mysql-server
    </div>
</p>

<p>
    <h4>Composser install</h4>
    <div>
        curl -sS https://getcomposer.org/installer -o composer-setup.php <br>
        php composer-setup.php
    </div>
</p>

<p>
    <h4>Node.js install</h4>
    <div>
        curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash - <br>
        sudo apt install -y nodejs
    </div>
</p>

<p>
    <h4>Phpstorm setup</h4>
    <div>
        sudo snap install phpstorm --classic
    </div>
</p>

<p>
    <h4>Clone project</h4>
    <div>
        cd ~/PhpstormProjects/ <br>
        git clone ssh://git@77.244.27.150:7999/pg/web.git<br>
        php composser.phar
    </div>
</p>

<p>
    <h4>Run</h4>
    <div>
        npm run watch<br>
        php artisan serve
    </div>
</p>