-- Event.module SQL Definitions
-- $Id: event.pgsql,v 1.5 2005/07/02 00:37:43 killes Exp $

CREATE TABLE event (
  nid int NOT NULL default '0',
  event_start int NOT NULL default '0',
  event_end int NOT NULL default '0',
  timezone int NOT NULL default '0',
  PRIMARY KEY (nid)
);
