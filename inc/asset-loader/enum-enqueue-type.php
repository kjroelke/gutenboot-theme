<?php
/**
 * Describes the allowable Enqueue types
 *
 * @package GutenBoot
 */

namespace GutenBoot;

/** Allowable Enqueue Types */
enum Enqueue_Type {
	case script;
	case style;
	case both;
}
