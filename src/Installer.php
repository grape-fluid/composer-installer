<?php
namespace Grapesc\GrapeFluid\Composer;

use Composer\Installer\InstallerInterface;
use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

class Installer extends LibraryInstaller implements InstallerInterface
{

	/**
	 * {@inheritDoc}
	 */
	public function getInstallPath(PackageInterface $package)
	{
		if ($package->getType() === 'grape-fluid-module') {
			return 'modules' . DIRECTORY_SEPARATOR . $this->getPackageName($package);
		} elseif ($package->getType() === 'grape-fluid-plugin') {
			return 'plugins' . DIRECTORY_SEPARATOR . $this->getPackageName($package);
		} elseif ($package->getType() === 'grape-fluid-bin') {
			return 'bin';
		} elseif ($package->getType() === 'grape-fluid-assets') {
			if ($package->getPrettyName() !== "grape-fluid/assets") {
				return 'assets' . DIRECTORY_SEPARATOR . str_replace('grape-fluid/', '', $package->getPrettyName());
			} else {
				return 'assets' . DIRECTORY_SEPARATOR . 'grape-fluid';
			}
		} else {
			return DIRECTORY_SEPARATOR;
		}
	}


	/**
	 * {@inheritDoc}
	 */
	public function supports($packageType)
	{
		return in_array($packageType, ['grape-fluid-module', 'grape-fluid-bin', 'grape-fluid-assets', 'grape-fluid-plugin']);
	}


	/**
	 * @param PackageInterface $package
	 * @return string
	 */
	protected function getPackageName(PackageInterface $package)
	{
		$name       = "";
		$prettyName = str_replace(["\\", "/"], "-", preg_replace("#^(grape-fluid)/#", "", $package->getPrettyName()));

		foreach (preg_split("/-/", $prettyName) as $part) {
			$name.= ucfirst(strtolower($part));
		}

		return $name;
	}

}
