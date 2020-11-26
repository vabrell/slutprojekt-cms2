<?php

class Luhn {
    private $sumTable = array(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), array(0, 2, 4, 6, 8, 1, 3, 5, 7, 9));

    /**
     * Calculate check digit according to Luhn's algorithm
     *
     * @param string $number
     * @return integer
     */
    public function calculate($number)
    {
        $length = strlen($number);
        $sum = 0;
        $flip = 1;
        // Sum digits (last one is check digit, which is not in parameter)
        for($i = $length-1; $i >= 0; --$i) $sum += $this->sumTable[$flip++ & 0x1][$number[$i]];
        // Multiply by 9
        $sum *= 9;
        // Last digit of sum is check digit
        return (int)substr($sum, -1, 1);
    }

	public function checkSSN($social_security_number) {
		// Check if pattern is incorrect
		$regex = "/^(19|20)?[0-9]{6}[- ]?[0-9]{4}$/";
		if (!preg_match($regex, $social_security_number)) return false;

		// Remove any dash and split the ssn
		$ssn = str_replace("-", "", $social_security_number);
		if (strlen($ssn) >= 11) {
			$ssn = substr($ssn, 2);
		}

		$check = (int)substr($ssn, -1);
		$ssn = substr($ssn, 0, 9);

		// Validate the ssn
		return $this->validate($ssn, $check);
	}

    /**
     * Validate number against check digit
     *
     * @param string $number
     * @param integer $digit
     * @return boolean
     */
    public function validate($number, $digit){
        $calculated = $this->calculate($number);
        if($digit === $calculated) return true;
        else return false;
    }
}