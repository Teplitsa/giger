# -*- mode: ruby -*-
# vi: set ft=ruby :


Vagrant.configure(2) do |config|
  config.vm.box = "scotch/box"

  config.vm.network "private_network", ip: "192.168.13.37"
  config.vm.hostname = "giger"
  
  config.vm.provision :shell, path: "giger.sh"
end
