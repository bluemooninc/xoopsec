;------ nao-pon - GitHub -----------------

[HypCommon]
dirname = "hypconf"
target_key = "HypCommon"
target_type = "TrustModule"
version = "1.04" ;hypconf version
detailed_version = "20120630" ;hypcommon version
replicatable= true
unzipdirlevel = 1
addon_url = "https://github.com/nao-pon/%s/zipball/master"
detail_url = "https://github.com/nao-pon/HypCommon"
license = "GPL"
required = "recommended"
description = "Setup HypCommonFunc class & configure, that enables cellular & smart phones theme, SPAM blocker, etc."
tag = "SpamBlocker Mobile Library Utility"
writable_dir[] = "%2$s/class/hyp_common/cache"
writable_dir[] = "%3$s/cache"
writable_dir[] = "%3$s/class/hyp_common/favicon/cache"
writable_dir[] = "%3$s/uploads/hyp_common"
writable_dir[] = "%3$s/uploads/hyp_common/kakasi"

install_only[] = "%2$s/class/hyp_common/cache"
install_only[] = "%3$s/cache"
install_only[] = "%3$s/class/hyp_common/favicon/cache"
install_only[] = "%3$s/uploads/hyp_common"

delete_file[] = "%3$s/class/hyp_common/hyp_search_engines.dat"
delete_file[] = "%3$s/class/hyp_common/mac_ext.dat"
delete_file[] = "%3$s/class/hyp_common/mac_ext_utf8.dat"
delete_file[] = "%3$s/class/hyp_common/spamsites.dat"
delete_file[] = "%3$s/class/hyp_common/spamwords.dat"
delete_file[] = "%3$s/class/hyp_common/win_ext.dat"
delete_file[] = "%3$s/class/hyp_common/win_ext_utf8.dat"
delete_file[] = "%3$s/class/hyp_common/favicon/conf.php.rename"
delete_file[] = "%3$s/class/hyp_common/favicon/group.def.hosts"
delete_file[] = "%3$s/class/hyp_common/favicon/group.hosts.rename"
delete_file[] = "%3$s/class/hyp_common/preload/spamsites.conf.dat.rename"
delete_file[] = "%3$s/class/hyp_common/preload/spamwords.conf.dat.rename"

[xpwiki]
dirname = "xpwiki"
target_key = "xpwiki"
target_type = "TrustModule"
version = "5.01.15" ;xpwiki version
detailed_version = "5.01.15" ;xpwiki version
replicatable= true
unzipdirlevel = 1
addon_url = "https://github.com/nao-pon/%s/zipball/master"
detail_url = "https://github.com/nao-pon/xpwiki"
license = "GPL"
required = "normal"
description = "Wiki module of PukiWiki base.<br />It require HypConf (HypCommon)."
tag = "Wiki PukiWiki"
writable_dir[] = "%2$s/modules/%1$s/attach"
writable_dir[] = "%2$s/modules/%1$s/attach/s"
writable_dir[] = "%2$s/modules/%1$s/private/backup"
writable_dir[] = "%2$s/modules/%1$s/private/cache"
writable_dir[] = "%2$s/modules/%1$s/private/cache/page"
writable_dir[] = "%2$s/modules/%1$s/private/cache/plugin"
writable_dir[] = "%2$s/modules/%1$s/private/diff"
writable_dir[] = "%2$s/modules/%1$s/private/trackback"
writable_dir[] = "%2$s/modules/%1$s/private/wiki"

install_only[] = "%2$s/common/fckxpwiki/.htaccess"
install_only[] = "%2$s/modules/%1$s/xoops_version.php"
install_only[] = "%2$s/modules/%1$s/attach"
install_only[] = "%2$s/modules/%1$s/image"
install_only[] = "%2$s/modules/%1$s/private"

delete_file[] = "%2$s/modules/xpwiki/attach/.cvsignore"
delete_file[] = "%2$s/modules/xpwiki/attach/s/.cvsignore"
delete_file[] = "%2$s/modules/xpwiki/private/backup/.cvsignore"
delete_file[] = "%2$s/modules/xpwiki/private/cache/.cvsignore"
delete_file[] = "%2$s/modules/xpwiki/private/counter/.cvsignore"
delete_file[] = "%2$s/modules/xpwiki/private/diff/.cvsignore"
delete_file[] = "%2$s/modules/xpwiki/private/trackback/.cvsignore"
delete_file[] = "%2$s/modules/xpwiki/private/wiki/.cvsignore"
delete_file[] = "%3$s/modules/xpwiki/ID/VerUp/3/private/wiki/.cvsignore"

[xelfinder]
dirname = "xelfinder"
target_key = "xelfinder"
target_type = "TrustModule"
version = "0.29" ;xelfinder version
replicatable= true
unzipdirlevel = 1
addon_url = "https://github.com/nao-pon/%s/zipball/master"
detail_url = "https://github.com/nao-pon/xelfinder"
license = "GPL"
required = "normal"
description = "Web file manager elFinder for XOOPS.<br />It require HypConf (HypCommon)."
tag = "FileManager FileUploader ImageUploaderImageManager elFinder"
writable_dir[] = "%2$s/modules/%1$s/cache"
writable_dir[] = "%2$s/modules/%1$s/cache/tmb"
writable_dir[] = "%3$s/uploads/xelfinder"

install_only[] = "%2$s/modules/%1$s/.htaccess"
install_only[] = "%2$s/modules/%1$s/cache"
install_only[] = "%3$s/uploads/xelfinder"
