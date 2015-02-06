<?php

/*
 * Copyright 2014 maurerit.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
?>
<html>
    <head>
        <title>Market Listings</title>
    </head>
    <body>
        <table>
            <tr>
                <th>Name</th>
                <th>Item Name</th>
                <th>Station Name</th>
                <th>Solar System</th>
                <th>Number Left</th>
                <th>Number Listed</th>
                <th>Price</th>
                <th>Orders Posted</th>
            </tr>
            <?php foreach ( $marketListings as $marketListing ): ?>
            <tr>
                <td><?php echo $marketListing->name ?></td>
                <td><?php echo $marketListing->typeName ?></td>
                <td><?php echo $marketListing->stationName ?></td>
                <td><?php echo $marketListing->solarSystemName ?></td>
                <td><?php echo $marketListing->remaining ?></td>
                <td><?php echo $marketListing->total ?></td>
                <td><?php echo $marketListing->avgPrice ?></td>
                <td><?php echo $marketListing->ords ?></td>
            </tr>
            <?php endforeach ?>
        </table>
    </body>
</html>