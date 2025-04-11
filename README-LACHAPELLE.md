# Problems in running:

# Locally

The configuration with traefik on local machine does not seems to work.
To make it work, simply expose a port locally and connect to that.

# In Production

The configuration seems to work if an existing traefik exists, however, if you start and stop, you need to wait a couple seconds (with a sleep)
before starting the main container again, after it has stopped.
The cause is unknown and would deserve some analysis.

