<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Kohana event subject. Uses the SPL observer pattern.
 *
 * @package    Calendar
 * @author     Kohana Team
 * @author     Sergei Gladkovskiy <smgladkovskiy@gmail.com>
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
abstract class Core_Event_Subject {

	/**
	 * Attached subject listeners
	 *
	 * @var array
	 */
	protected $listeners = array();

	/**
	 * Attach an observer to the object.
	 *
	 * @chainable
	 * @throws Kohana_Exception
	 * @param  Event_Observer   $obj
	 * @return Event_Subject
	 */
	public function attach(Event_Observer $obj)
	{
		if ( ! ($obj instanceof Event_Observer))
			throw new Kohana_Exception('eventable.invalid_observer', get_class($obj), get_class($this));

		// Add a new listener
		$this->listeners[spl_object_hash($obj)] = $obj;

		return $this;
	}

	/**
	 * Detach an observer from the object.
	 *
	 * @chainable
	 * @param  Event_Observer|Core_Event_Observer $obj
	 * @return Event_Subject
	 */
	public function detach(Event_Observer $obj)
	{
		// Remove the listener
		unset($this->listeners[spl_object_hash($obj)]);

		return $this;
	}

	/**
	 * Notify all attached observers of a new message.
	 *
	 * @chainable
	 * @param  mixed $message
	 * @return Event_Subject
	 */
	public function notify($message)
	{
		foreach ($this->listeners as $obj)
		{
			$obj->notify($message);
		}

		return $this;
	}

} // End Core_Event_Subject