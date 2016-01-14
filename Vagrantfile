# -*- mode: ruby -*-
# vi: set ft=ruby :


Vagrant.configure(2) do |config|
  config.vm.box = "scotch/box"
  
  # network
  config.vm.network "private_network", ip: "192.168.13.37"
  config.vm.hostname = "giger"
  
  # sync folder
  config.vm.synced_folder ".", "/var/www/", :mount_options => ["dmode=777", "fmode=666"] 
  config.vm.synced_folder ".", "/vagrant", disabled: true
  
  #fix for no-tty
  config.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"
  
  #provision
  config.vm.provision :shell, path: "provision/run.sh"
end