<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2024
 * @package Base
 * @subpackage Cache
 */


namespace Aimeos\Base\Cache;


/**
 * Laravel caching implementation.
 *
 * @package Base
 * @subpackage Cache
 */
class Laravel
	extends \Aimeos\Base\Cache\Base
	implements \Aimeos\Base\Cache\Iface
{
	private \Illuminate\Contracts\Cache\Store $object;


	/**
	 * Initializes the object instance.
	 *
	 * @param \Illuminate\Contracts\Cache\Store $cache Laravel cache object
	 */
	public function __construct( \Illuminate\Contracts\Cache\Store $cache )
	{
		$this->object = $cache;
	}


	/**
	 * Removes all entries from the cache so it's completely empty.
	 *
	 * @inheritDoc
	 *
	 * This method deletes all cached entries from the cache server the client
	 * has access to. This method is primarily usefull to provide a clean start
	 * before new entries are added to the cache and you don't know which
	 * entries are still in the cache.
	 *
	 * @return bool True on success and false on failure
	 */
	public function clear() : bool
	{
		return $this->object->flush();
	}


	/**
	 * Removes the cache entry identified by the given key.
	 *
	 * @inheritDoc
	 *
	 * @param string $key Key string that identifies the single cache entry
	 * @return bool True if the item was successfully removed. False if there was an error
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function delete( string $key ) : bool
	{
		return $this->object->forget( $key );
	}


	/**
	 * Removes the cache entries identified by the given keys.
	 *
	 * @inheritDoc
	 *
	 * @param iterable $keys List of key strings that identify the cache entries that should be removed
	 * @return bool True if the items were successfully removed. False if there was an error.
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function deleteMultiple( iterable $keys ) : bool
	{
		foreach( $keys as $key ) {
			$this->object->forget( $key );
		}

		return true;
	}


	/**
	 * Removes the cache entries identified by the given tags.
	 *
	 * @inheritDoc
	 *
	 * @param iterable $tags List of tag strings that are associated to one or more cache entries that should be removed
	 * @return bool True if the items were successfully removed. False if there was an error.
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function deleteByTags( iterable $tags ) : bool
	{
		return $this->object->flush();
	}


	/**
	 * Returns the value of the requested cache key.
	 *
	 * @inheritDoc
	 *
	 * @param string $key Path to the requested value like product/id/123
	 * @param mixed $default Value returned if requested key isn't found
	 * @return mixed Value associated to the requested key. If no value for the
	 *	key is found in the cache, the given default value is returned
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function get( string $key, $default = null )
	{
		if( ( $entry = $this->object->get( $key ) ) !== null ) {
			return $entry;
		}

		return $default;
	}


	/**
	 * Returns the cached values for the given cache keys.
	 *
	 * @inheritDoc
	 *
	 * @param iterable $keys List of key strings for the requested cache entries
	 * @param mixed $default Default value to return for keys that do not exist
	 * @return iterable A list of key => value pairs. Cache keys that do not exist or are stale will have $default as value.
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function getMultiple( iterable $keys, $default = null ) : iterable
	{
		$result = [];

		foreach( $keys as $key )
		{
			if( ( $entry = $this->object->get( $key ) ) !== false ) {
				$result[$key] = $entry;
			} else {
				$result[$key] = $default;
			}
		}

		return $result;
	}


	/**
	 * Determines whether an item is present in the cache.
	 *
	 * @inheritDoc
	 *
	 * @param string $key The cache item key
	 * @return bool True if cache entry is available, false if not
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function has( string $key ) : bool
	{
		if( $this->object->get( $key ) !== null ) {
			return true;
		}

		return false;
	}


	/**
	 * Sets the value for the specified key.
	 *
	 * @inheritDoc
	 *
	 * @param string $key Key string for the given value like product/id/123
	 * @param mixed $value Value string that should be stored for the given key
	 * @param \DateInterval|int|string|null $expires Date interval object,
	 *  date/time string in "YYYY-MM-DD HH:mm:ss" format or as integer TTL value
	 *  when the cache entry will expiry
	 * @param iterable $tags List of tag strings that should be assoicated to the cache entry
	 * @return bool True on success and false on failure.
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function set( string $key, $value, $expires = null, iterable $tags = [] ) : bool
	{
		if( $expires instanceof \DateInterval ) {
			return $this->object->put( $key, $value, (int) ( date_create()->add( $expires )->format( 'Y-m-d H:i:s' ) - time() ) );
		} elseif( is_string( $expires ) ) {
			return $this->object->put( $key, $value, (int) ( date_create( $expires )->getTimestamp() - time() ) );
		} elseif( is_int( $expires ) ) {
			return $this->object->put( $key, $value, (int) $expires );
		} else {
			return $this->object->forever( $key, $value );
		}
	}


	/**
	 * Adds the given key/value pairs to the cache.
	 *
	 * @inheritDoc
	 *
	 * @param iterable $pairs Associative list of key/value pairs. Both must be a string
	 * @param \DateInterval|int|string|null $expires Date interval object,
	 *  date/time string in "YYYY-MM-DD HH:mm:ss" format or as integer TTL value
	 *  when the cache entry will expiry
	 * @param iterable $tags List of tags that should be associated to the cache entries
	 * @return bool True on success and false on failure.
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function setMultiple( iterable $pairs, $expires = null, iterable $tags = [] ) : bool
	{
		foreach( $pairs as $key => $value ) {
			$this->set( $key, $value, $expires, $tags );
		}

		return true;
	}
}
