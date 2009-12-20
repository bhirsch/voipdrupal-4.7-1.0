This documentation is intended for users of the location module that need help
with various tasks relating to the features of the locations module.  It is updated
on subsequent revisions based on requests for support and frequently asked questions.



Integrating location module with CiviCRM
----------------------------------------
If you installed CivicSpace with CiviCRM and have CiviCRM enabled, then your CiviCRM 
should already be set up to save addresses via the location module as well as with
CiviCRM's own admin interface.

However this depends on making sure that you have a CiviCRM profile activated that
records user addresses.  Again, this profile was enabled for CiviCRM out of the box
with default CivicSpace installs.  However, if you disabled the profile, or are
working with CiviCRM in a seperate Drupal installation, you may want to read on
to find out how to set up your CiviCRM to interact with your location module:

    Set up the 'address' profile in the CiviCRM admininstration:
    
(a) To do this, you need to go to 'q=civicrm/admin/uf/group". Here, you will see a listing 
    of CiviCRM profiles.  If you see one called address and it is enabled, then you're 
    ready to go.
    
(b) However, if you don't see one, you will want to click the link labelled
    ">> New CiviCRM Profile".
    
(c) This will take you to a page where you will be prompted for a name for your new 
    CiviCRM profile.  Enter 'address' as the name.
    
(d) Now, you will be taken back to the listing of CiviCRM profiles where you will want
    to click the link that allows you to "View and Edit Fields" in your newly created 
    profile.
    
(e) Add fields in the following order (where you select the below field names in a drop
    down):
    
      Street Address
      Supplemental Address 1
      City
      State
      Postal Code
      Country
      
    For each of these, assign a weight of '0' and decide whether you want each of these
    fields to show up on your site's registration forms (there will be a checkbox for
    this for each field you add to the profile).
   

After taking these steps, users will be able to edit their addresses in their user
accounts.  Addresses submitted this way will registered both by the CiviCRM module
and the location module.  This means that both module's features will be applicable
to user addresses.

