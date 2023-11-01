-- HEAD --
description = [[ Simple script to enumerate and report open TCP ports. ]]

-- RULE --
portrule = function(host, port)
	return port.protocol == "tcp" and port.state == "open"
end

-- ACTION --
action = function(host, port)
	return "This port is open!"
end
