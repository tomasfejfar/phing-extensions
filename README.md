phing-extensions
================

Helper classes for use with phing

VersionCompareCondition
----------------------

**Note**: this will work in the next Phing revision after 2.4.12. Custom conditions are not supported before that revision. 

Used in `if` task to branch the deploy based on version. Usage:

````
<taskdef name="version-compare"  classname="VersionCompareCondition" />

<if>
	<version-compare version="${project.version}" desiredVersion="1.3" />
	<then>
		<echo>Version is bigger or equal than 1.3</echo>
	</then>
	<else>
		<echo>Version is smaller than 1.3</echo>
	</else>
</if>
````

Params:

* **version** - your project's version
* **desiredVersion** - version you want to compare to
* **operator** - comparison operator (anything supported by php's `version_comapare()`) - default: `>=`
* **debug** - echoes the comparison in human-readable way