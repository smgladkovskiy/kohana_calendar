<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Kohana event observer. Uses the SPL observer pattern.
 *
 * @package    Calendar
 * @author     Kohana Team
 * @author     Sergei Gladkovskiy <smgladkovskiy@gmail.com>
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
abstract class Core_Event_Observer {

	/**
	 * Calling object
	 *
	 * @var Event_Subject
	 */
	protected $caller;

	/**
	 * Initializes a new observer and attaches the subject as the caller.
	 *
	 * @param Event_Subject $caller
	 */
	public function __construct(Event_Subject $caller)
	{
		// Update the caller
		$this->update($caller);
	}

	/**
	 * Updates the observer subject with a new caller.
	 *
	 * @chainable
	 * @throws Kohana_Exception
	 * @param  Event_Subject $caller
	 * @return Event_Observer
	 */
	public function update(Event_Subject $caller)
	{
		if ( ! ($caller instanceof Event_Subject))
			throw new Kohana_Exception('event.invalid_subject', get_class($caller), get_class($this));

		// Update the caller
		$this->caller = $caller;

		return $this;
	}

	/**
	 * Detaches this observer from the subject.
	 *
	 * @chainable
	 * @return Core_Event_Observer
	 */
	public function remove()
	{
		// Detach this observer from the caller
		$this->caller->detach($this);

		return $this;
	}

	/**
	 * Notify the observer of a new message. This function must be defined in
	 * all observers and must take exactly one parameter of any type.
	 *
	 * @abstract
	 * @param  $message
	 * @return void
	 */
	abstract public function notify($message);

} // End Core_Event_Observer