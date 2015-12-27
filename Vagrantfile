# -*- mode: ruby -*-
# vi: set ft=ruby :


Vagrant.configure(2) do |config|
  config.vm.box = "scotch/box"

  config.vm.network "private_network", ip: "192.168.13.37"
  config.vm.hostname = "giger"
  
  config.vm.synced_folder ".", "/var/www/public", :mount_options => ["dmode=777", "fmode=666"] 
  config.vm.synced_folder ".", "/vagrant", disabled: true

  config.vm.provision :shell, path: "giger.sh"
end
