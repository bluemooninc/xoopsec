;------ Xoops X (Ten) - GitHub -----------------

[XoopsX_CorePack]
dirname = "legacy"
target_key = "XoopsX_CorePack"
target_type = "X2Module"
version = "2.01"
detailed_version = "CorePack 20120817" ;legacy detailed_version
replicatable= false
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/legacy/zipball/CorePack"
detail_url = "https://github.com/XoopsX/legacy"
license = "GPL"
required = "required"
description = "XoopsX (XOOPS Cube legacy Core, protetor and Altsys module packages)<br />If this process has been failed, XCL will not work. The X-update strongly recommend you to backup whole site before update."
install_only[] = "%2$s/README*"
install_only[] = "%2$s/install*"
install_only[] = "%2$s/mainfile.php"
install_only[] = "%2$s/favicon.ico"
install_only[] = "%2$s/modules/xupdate*"
install_only[] = "%3$s/modules/xupdate*"
install_only[] = "%3$s/uploads/xupdate*"
delete_dir[] = "%3$s/cache/smarty_cache"
delete_file[] = "%2$s/modules/legacy/admin/theme/design/bg_page.jpg"

[bulletin]
dirname = "bulletin"
target_key = "bulletin"
target_type = "TrustModule"
version = "3.00"
replicatable= true
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/bulletin"
license = "GPL"
required = "normal"
description = "The news module of the slash dot style which a user can comment freely "

[cubeUtils]
dirname = "cubeUtils"
target_key = "cubeUtils"
target_type = "X2Module"
version = "0.80"
replicatable= false
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/cubeUtils"
license = "GPL"
required = "normal"
description = "A multi-language and the module for login extension"

[d3downloads]
dirname = "d3downloads"
target_key = "d3downloads"
target_type = "TrustModule"
version = "1.48"
replicatable= true
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/d3downloads"
license = "GPL"
required = "normal"
description = "The download module corresponding to the duplicatable version 3 (D3) specification "

[d3forum]
dirname = "d3forum"
target_key = "d3forum"
target_type = "TrustModule"
version = "0.86"
replicatable= true
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/d3forum"
license = "GPL"
required = "recommended"
description = "The forum module of XOOPS"

[d3pipes]
dirname = "d3pipes"
target_key = "d3pipes"
target_type = "TrustModule"
version = "0.69"
replicatable= true
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/d3pipes"
license = "GPL"
required = "normal"
description = "The module for treating syndications freely , such as RSS"

[gnavi]
dirname = "gnavi"
target_key = "gnavi"
target_type = "TrustModule"
version = "0.97"
replicatable= true
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/gnavi"
license = "GPL"
required = "normal"
description = "The area guide creation module using GoogleMap"

[mobile_templates]
dirname = "mobile_templates"
target_key = "mobile_templates"
target_type = "X2Module"
version = "1.00"
replicatable= false
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/mobile_templates"
license = "GPL"
required = "recommended"
description = "The under theme template set of a ktai_default theme for displaying and operating it with mobile phones"

[myalbum]
dirname = "myalbum"
target_key = "myalbum-p"
target_type = "X2Module"
version = "2.89"
replicatable= true
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/myalbum"
license = "GPL"
required = "normal"
description = "It is a module which can make a Photo album within XOOPS"
writable_dir[] = "%2$s/uploads/photos"
writable_dir[] = "%2$s/uploads/thumbs"
install_only[] = "%2$s/uploads/photos"
install_only[] = "%2$s/uploads/thumbs"

[multiMenu]
dirname = "multiMenu"
target_key = "multiMenu"
target_type = "X2Module"
version = "1.20"
replicatable= false
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/multiMenu"
license = "GPL"
required = "normal"
description = "A free multi-menu is displayed on Xoops"

[none]
dirname = "none"
target_key = "none"
target_type = "TrustModule"
version = "1.12"
replicatable= true
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/none"
license = "GPL"
required = "normal"
description = "The template strengthening version of the none module ,which nothing special carries out"

[openID]
dirname = "openid"
target_key = "openID"
target_type = "X2Module"
version = "0.3" ;openid version
replicatable= false
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/openID"
license = "GPL"
required = "normal"
description = "The module whose login is enabled by OpenID authority at XOOPS Cube "

[piCal]
dirname = "piCal"
target_key = "piCal"
target_type = "X2Module"
version = "0.95"
replicatable= false
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/piCal"
license = "GPL"
required = "normal"
description = "The calendar module"

[pico]
dirname = "pico"
target_key = "pico"
target_type = "TrustModule"
version = "1.83"
replicatable= true
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/pico"
license = "GPL"
required = "normal"
description = "Static contents creation module"

[search]
dirname = "search"
target_key = "search"
target_type = "X2Module"
version = "2.05"
replicatable= false
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/search"
license = "GPL"
required = "normal"
description = "The alternative module of search of a xoops core "

[xpress]
dirname = "xpress"
target_key = "xpress"
target_type = "X2Module"
version = "2.42"
replicatable= true
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/xpress"
license = "GPL"
required = "normal"
description = "a module which can use the blog tool wordpress on XOOPS Cube"

[xsns]
dirname = "xsns"
target_key = "xsns"
target_type = "TrustModule"
version = "1.12"
replicatable= true
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/xsns"
license = "GPL"
required = "normal"
description = "It is a module which can start SNS within XOOPS"
writable_dir[] = "%2$s/uploads/xsns"
writable_dir[] = "%2$s/uploads/xsns/thumbnail1"
writable_dir[] = "%2$s/uploads/xsns/thumbnail2"
writable_dir[] = "%2$s/uploads/xsns/thumbnail3"
install_only[] = "%2$s/uploads/xsns"
install_only[] = "%2$s/uploads/xsns/thumbnail1"
install_only[] = "%2$s/uploads/xsns/thumbnail2"
install_only[] = "%2$s/uploads/xsns/thumbnail3"

[xupdate]
dirname = "xupdate"
target_key = "xupdate"
target_type = "TrustModule"
version = "0.15" ;xupdate version
replicatable= false
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/xupdate"
license = "GPL"
required = "recommended"
description = "You can download the add-on of your choice<br />Update of X-update(updater) self is also possible"
delete_file[] = "%3$s/settings/{xupdate_mystore.ini.dist"
delete_file[] = "%3$s/modules/xupdate/templates/xupdate_store_delete.html"
delete_file[] = "%3$s/modules/xupdate/templates/xupdate_store_edit.html"
delete_file[] = "%3$s/modules/xupdate/templates/xupdate_store_list.html"
delete_file[] = "%3$s/modules/xupdate/templates/xupdate_store_view.html"

[xwords]
dirname = "xwords"
target_key = "xwords"
target_type = "X2Module"
version = "0.47"
replicatable= false
unzipdirlevel = 1
addon_url = "https://github.com/XoopsX/%s/zipball/master"
detail_url = "https://github.com/XoopsX/xwords"
license = "GPL"
required = "normal"
description = "Japanese dictionary module"
writable_dir[] = "%2$s/uploads/xwords"
writable_file[] = "%2$s/uploads/xwords/entries.php"
writable_file[] = "%2$s/uploads/xwords/entries_temp.php"
install_only[] = "%2$s/uploads/xwords/entries.php"
install_only[] = "%2$s/uploads/xwords/entries_temp.php"

