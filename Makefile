VERSION=$(shell head -n 1 VERSION)

all: ranzhi
clean:
	rm -fr ranzhi
	rm -fr *.zip
ranzhi:
	mkdir ranzhi
	cp -fr app ranzhi/
	cp -fr bin ranzhi/
	cp -fr config ranzhi/ && rm -fr ranzhi/config/my.php
	mkdir ranzhi/db
	cp -fr db/* ranzhi/db/
	cp -fr doc ranzhi/ && rm -fr ranzhi/doc/phpdoc && rm -fr ranzhi/doc/doxygen
	cp -fr framework ranzhi/
	cp -fr lib ranzhi/
	mkdir ranzhi/tmp/
	rm -fr ranzhi/db/temp.sql
	mkdir ranzhi/tmp/backup/
	mkdir ranzhi/tmp/cache/ 
	mkdir ranzhi/tmp/extension/
	mkdir ranzhi/tmp/log/
	mkdir ranzhi/tmp/model/
	mkdir ranzhi/tmp/package/
	cp -fr www ranzhi && rm -fr ranzhi/www/data/ && mkdir -p ranzhi/www/data/upload
	cp VERSION ranzhi/
	# Combine js and css files.
	cp -fr tools ranzhi/tools && cd ranzhi/tools/ && php ./minifyfront.php && php ./cn2tw.php
	rm -fr ranzhi/tools
	# Delete the useless files.
	find ranzhi -name .git | xargs rm -fr
	find ranzhi -name tests | xargs rm -fr
	# Add ext directory to config and each module.
	test -d ranzhi/config/ext || mkdir ranzhi/config/ext
	for app in `ls ranzhi/app/`; do for module in `ls ranzhi/app/$$app/`; do test -d ranzhi/app/$$app/$$module/ext || mkdir ranzhi/app/$$app/$$module/ext; done; done
	find ranzhi/ -name ext | xargs chmod -R 777
	# Add index.html to each directory.
	for path in `find ranzhi/ -type d`; do touch "$$path/index.html"; done	
	rm ranzhi/www/index.html
	rm ranzhi/www/sys/index.html
	rm ranzhi/www/crm/index.html
	rm ranzhi/www/cash/index.html
	rm ranzhi/www/oa/index.html
	rm ranzhi/www/team/index.html
	rm ranzhi/www/doc/index.html
	rm ranzhi/www/proj/index.html
	# Copy .htaccess and .ztaccess
	cp ranzhi/www/sys/.*taccess ranzhi/www/crm/
	cp ranzhi/www/sys/.*taccess ranzhi/www/cash/
	cp ranzhi/www/sys/.*taccess ranzhi/www/oa/
	cp ranzhi/www/sys/.*taccess ranzhi/www/team/
	cp ranzhi/www/sys/.*taccess ranzhi/www/doc/
	cp ranzhi/www/sys/.*taccess ranzhi/www/proj/
	# Adjust .ztaccess of each app.
	sed -i 's/\/ranzhi\/sys\/index.php/\/ranzhi\/crm\/index.php/' ranzhi/www/crm/.ztaccess
	sed -i 's/\/ranzhi\/sys\/index.php/\/ranzhi\/cash\/index.php/' ranzhi/www/cash/.ztaccess
	sed -i 's/\/ranzhi\/sys\/index.php/\/ranzhi\/oa\/index.php/' ranzhi/www/oa/.ztaccess
	sed -i 's/\/ranzhi\/sys\/index.php/\/ranzhi\/team\/index.php/' ranzhi/www/team/.ztaccess
	sed -i 's/\/ranzhi\/sys\/index.php/\/ranzhi\/doc\/index.php/' ranzhi/www/doc/.ztaccess
	sed -i 's/\/ranzhi\/sys\/index.php/\/ranzhi\/proj\/index.php/' ranzhi/www/proj/.ztaccess
	# Change mode.
	chmod -R 777 ranzhi/tmp/
	chmod -R 777 ranzhi/www/data
	chmod -R 777 ranzhi/config
	chmod a+rx ranzhi/bin/*
	# Zip it.
	zip -rm -9 ranzhi.$(VERSION).zip ranzhi
deb:
	mkdir buildroot
	cp -r build/debian/DEBIAN buildroot
	sed -i '/^Version/cVersion: ${VERSION}' buildroot/DEBIAN/control
	mkdir buildroot/opt
	mkdir buildroot/etc/apache2/sites-enabled/ -p
	cp build/debian/ranzhi.conf buildroot/etc/apache2/sites-enabled/
	cp ranzhi.${VERSION}.zip buildroot/opt
	cd buildroot/opt; unzip ranzhi.${VERSION}.zip; rm ranzhi.${VERSION}.zip
	sed -i 's/index.php/\/ranzhi\/sys\/index.php/' buildroot/opt/ranzhi/www/sys/.htaccess
	sed -i 's/index.php/\/ranzhi\/crm\/index.php/' buildroot/opt/ranzhi/www/crm/.htaccess
	sed -i 's/index.php/\/ranzhi\/cash\/index.php/' buildroot/opt/ranzhi/www/cash/.htaccess
	sed -i 's/index.php/\/ranzhi\/oa\/index.php/' buildroot/opt/ranzhi/www/oa/.htaccess
	sed -i 's/index.php/\/ranzhi\/team\/index.php/' buildroot/opt/ranzhi/www/team/.htaccess
	sed -i 's/index.php/\/ranzhi\/doc\/index.php/' buildroot/opt/ranzhi/www/doc/.htaccess
	sed -i 's/index.php/\/ranzhi\/proj\/index.php/' buildroot/opt/ranzhi/www/proj/.htaccess
	sudo dpkg -b buildroot/ ranzhi_${VERSION}_1_all.deb
	rm -rf buildroot
rpm:
	mkdir ~/rpmbuild/SPECS -p
	cp build/rpm/ranzhi.spec ~/rpmbuild/SPECS
	sed -i '/^Version/cVersion:${VERSION}' ~/rpmbuild/SPECS/ranzhi.spec
	mkdir ~/rpmbuild/SOURCES
	cp ranzhi.${VERSION}.zip ~/rpmbuild/SOURCES
	mkdir ~/rpmbuild/SOURCES/etc/httpd/conf.d/ -p
	cp build/debian/ranzhi.conf ~/rpmbuild/SOURCES/etc/httpd/conf.d/
	mkdir ~/rpmbuild/SOURCES/opt/ -p
	cd ~/rpmbuild/SOURCES; unzip ranzhi.${VERSION}.zip; mv ranzhi opt/ranzhi;
	sed -i 's/index.php/\/ranzhi\/sys\/index.php/' ~/rpmbuild/SOURCES/opt/ranzhi/www/sys/.htaccess
	sed -i 's/index.php/\/ranzhi\/crm\/index.php/' ~/rpmbuild/SOURCES/opt/ranzhi/www/crm/.htaccess
	sed -i 's/index.php/\/ranzhi\/cash\/index.php/' ~/rpmbuild/SOURCES/opt/ranzhi/www/cash/.htaccess
	sed -i 's/index.php/\/ranzhi\/oa\/index.php/' ~/rpmbuild/SOURCES/opt/ranzhi/www/oa/.htaccess
	sed -i 's/index.php/\/ranzhi\/team\/index.php/' ~/rpmbuild/SOURCES/opt/ranzhi/www/team/.htaccess
	sed -i 's/index.php/\/ranzhi\/doc\/index.php/' ~/rpmbuild/SOURCES/opt/ranzhi/www/doc/.htaccess
	sed -i 's/index.php/\/ranzhi\/proj\/index.php/' ~/rpmbuild/SOURCES/opt/ranzhi/www/proj/.htaccess
	cd ~/rpmbuild/SOURCES; tar -czvf ranzhi-${VERSION}.tar.gz etc opt; rm -rf ranzhi.${VERSION}.zip etc opt;
	rpmbuild -ba ~/rpmbuild/SPECS/ranzhi.spec
	cp ~/rpmbuild/RPMS/noarch/ranzhi-${VERSION}-1.noarch.rpm ./
	rm -rf ~/rpmbuild
