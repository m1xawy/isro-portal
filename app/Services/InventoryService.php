<?php

namespace App\Services;

use App\Models\SRO\Account\ItemNameDesc;
use App\Models\SRO\Account\MagOptDesc;
use App\Models\SRO\Shard\Inventory;
use App\Models\SRO\Shard\InventoryForAvatar;
use App\Models\SRO\Shard\TradeEquipInventory;

class InventoryService
{
    const WEAPON = 6;
    const SHIELD = 4;
    const ACC = 5;
    const SET = 2;
    const DRESS = 13;
    const DEVIL = 14;

    /**
     * @param $characterId
     * @param $maxSlot
     * @param $minSlot
     * @return array
     */
    public function getInventorySet($characterId, $maxSlot, $minSlot): array
    {
        return $this->convertItemList(Inventory::getInventory($characterId, $maxSlot, $minSlot));
    }

    /**
     * @param $characterId
     * @return array
     */
    public function getInventoryAvatar($characterId): array
    {
        return $this->convertItemList(InventoryForAvatar::getInventoryForAvatar($characterId));
    }

    /**
     * @param $characterId
     * @return array
     */
    public function getInventoryJob($characterId): array
    {
        return $this->convertItemList(TradeEquipInventory::getInventoryForJob($characterId));
    }

    /**
     * @param $inventory
     * @param bool $filter
     * @return array
     */
    public function convertItemList($inventory, $filter = false): array
    {
        $aSet = [];
        if (!$inventory) {
            return [];
        }
        foreach ($inventory as $iKey => $aCurItem) {
            $aSpecialInfo = [];
            $aInfo = $aCurItem;
            $aInfo['info'] = $this->getItemInfo($aCurItem);
            $aInfo['blues'] = $this->getBluesStats($aCurItem, $aSpecialInfo);
            $aInfo['whitestats'] = $this->getWhiteStats($aCurItem, $aSpecialInfo);

            if (array_key_exists('Slot', $aInfo['info'])) {
                //
                $i = $aInfo['info']['Slot'];
            } else {
                $i = $aCurItem['Slot'] ?? $aCurItem['ID64'];
            }

            if (!isset($aCurItem['MaxStack'])) {
                $aInfo['MaxStack'] = 0;
            }

            if ($aCurItem['MaxStack'] > 1) {
                $aSet[$i]['amount'] = $aCurItem['Data'];
                $aInfo['amount'] = $aCurItem['Data'];
            } else {
                $aSet[$i]['amount'] = false;
                $aInfo['amount'] = 0;
            }

            $aSet[$i]['Slot'] = $i;
            $aSet[$i]['Serial64'] = data_get($aInfo, 'Serial64', null);
            $aSet[$i]['TypeID2'] = data_get($aInfo, 'TypeID2', 0);
            $aSet[$i]['OptLevel'] = data_get($aInfo, 'OptLevel', 0);
            $aSet[$i]['RefItemID'] = data_get($aCurItem, 'RefItemID', 0);
            $aSet[$i]['special'] = data_get($aInfo['info'], 'sox', null);
            $aSet[$i]['ItemID'] = data_get($aCurItem, 'ID64', 0);
            $aSet[$i]['ItemName'] = data_get($aInfo['info'], 'WebName', 'Unknown');
            $aSet[$i]['imgpath'] = $this->getItemIcon($aCurItem['AssocFileIcon128']);
            $aSet[$i]['WebInventory'] = $aInfo['info'];

            if ($filter) {
                $aSet[$i]['CharID'] = $aCurItem['CharID'];
                $aSet[$i]['CharName'] = $aCurItem['CharName16'];
                $aSet[$i]['StorageState'] = $aCurItem['UserJID'];
            }
            try {
                $aSet[$i]['data'] = $aInfo;
            } catch (\Throwable $e) {
//                 Throw error
            }
        }
        return $aSet;
    }

    /**
     * @param $aItem
     * @return string
     */
    public function getItemIcon($aItem): string
    {
        $iconPath = $aItem;
        $iconPath = str_replace('\\', '/', $iconPath);

        if (substr($iconPath, -4) == '.ddj') {
            $iconPath = sprintf('%s.png', substr($iconPath, 0, strlen($iconPath) - 4));
        }

        return sprintf('/images/sro/%s', $iconPath);
    }

    /**
     * @param $aItem
     * @return array
     */
    protected function getItemInfo($aItem): array
    {
        $aData = [];
        $aData['ReqLevel1'] = $aItem['ReqLevel1'];
        $aData['CanSell'] = $aItem['CanSell'];
        $aData['CanTrade'] = $aItem['CanTrade'];
        $aData['CanBuy'] = $aItem['CanBuy'];
        $aData['TypeID2'] = $aItem['TypeID2'];
        $aData['TypeID3'] = $aItem['TypeID3'];
        $aData['TypeID4'] = $aItem['TypeID4'];
        $aData['Price'] = $aItem['Price']; // Npc Price
        $aData['sox'] = null; // For Blade
        $aData['OptLevel'] = data_get($aItem, 'OptLevel', 0);
        $aData['Degree'] = data_get($aItem, 'ItemClass', '0'); // For Blade
        $aData['WebName'] = ItemNameDesc::getItemRealName($aItem['NameStrID128']);

        if (!in_array($aItem['TypeID2'], [1, 4])) {
            return $aData;
        }

        $aStats = explode('_', $aItem['CodeName128']);
        $aData['Race'] = config('settings.item.race')[$aStats[1]] ?? null;

        if ($aItem['TypeID2'] == 4) {
            if ($aItem['TypeID3'] > 0 && $aItem['TypeID4'] > 0) {
                if (array_key_exists($aItem['TypeID3'], config('settings.item.job_type'))) {
                    if (array_key_exists($aItem['TypeID4'], config('settings.item.job_type')[$aItem['TypeID3']])) {
                        $aData['JobType'] = config('settings.item.job_type')[$aItem['TypeID3']][$aItem['TypeID4']] ?? null;
                    }
                }
            }

            if (array_key_exists($aItem['Slot'], config('settings.item.job_detail'))) {
                $aData['JobDetail'] = config('settings.item.job_detail')[$aItem['Slot']] ?? null;
            }

            if (array_key_exists($aItem['ItemClass'], config('settings.item.job_degree'))) {
                $aData['JobDegree'] = config('settings.item.job_degree')[$aItem['ItemClass']] ?? null;
            }
        }

        if ($aItem['TypeID3'] == 14) {
            $aTime = self::diffTime($aItem['Data'] - time());
            $aData['devilTimeEnd'] = $aItem['Data'] === 0 ? '28Day' : ((time() > $aItem['Data']) ? '0Day 0Hour 0Minute' : $aTime['day'] . 'Day ' . $aTime['hour'] . 'Hour ' . $aTime['min'] . 'Minute');
        }

        if (isset($aStats[4], $aStats[5], $aStats[6])) {
            $setKey = $aStats[4] . '_' . $aStats[5] . '_' . $aStats[6];

            if (array_key_exists($setKey, config('settings.item.rare_name'))) {
                $aItem['RareName'] = config('settings.item.rare_name')[$setKey][$aItem['Slot']];
            }
        }

        switch ($aItem['TypeID3']) {
            case self::WEAPON:
                $aData['Type'] = config('settings.item.weapon_type')[$aStats[1]][$aStats[2]] ?? '';
                $aData['Degree'] = self::getDegree4ItemClass($aItem['ItemClass']);
                $aData['sox'] = self::getSOXRate4ItemClass($aItem['ItemClass'], $aItem['Rarity']);
                break;
            case self::SHIELD:
                //set
                $aData['Type'] = config('settings.item.weapon_type')[$aStats[1]][$aStats[2]] ?? '';
                $aData['Degree'] = self::getDegree4ItemClass($aItem['ItemClass']);
                $aData['sox'] = self::getSOXRate4ItemClass($aItem['ItemClass'], $aItem['Rarity']);
                break;
            case 12:
            case self::ACC:
                $aData['Type'] = $aStats[2];
                $aData['Degree'] = self::getDegree4ItemClass($aItem['ItemClass']);
                $aData['sox'] = self::getSOXRate4ItemClass($aItem['ItemClass'], $aItem['Rarity']);
                break;
            /**
             * DEVIL
             */
            case self::DEVIL:
                $aData['Type'] = 'Devil´s Spirit';
                $aData['Degree'] = 'devil';
                $aData['Sex'] = config('settings.item.sex')[$aItem['ReqGender']];
                $aTime = self::diffTime($aItem['Data'] - time());
                $buffer = ((time() > $aItem['Data']) ? '0Day 0Hour 0Minute' : $aTime['day'] . 'Day ' . $aTime['hour'] . 'Hour ' . $aTime['min'] . 'Minute');
                $aData['timeEnd'] = $aItem['Data'] === 0 ? '28Day' : $buffer;
                $aData['Slot'] = 0;
                break;
            /**
             * DRESS
             */
            case self::DRESS:
                $aData['Type'] = config('settings.item.avatar_type')[$aItem['MaxMagicOptCount']] ?? null;
                //$aData['Type'] = $aStats[2] . ' ' . ((!isset($aStats[5]) || is_numeric($aStats[5])) ? 'dress' : $aStats[5]);
                //$aData['Degree'] = $aStats[3];
                $aData['Sex'] = config('settings.item.sex')[$aItem['ReqGender']] ?? null;
                $aData['Slot'] = $aItem['TypeID4'];
                break;

            default:
                $aData['Degree'] = self::getDegree4ItemClass($aItem['ItemClass']);
                if (isset(config('settings.item.sex')[$aItem['ReqGender']])) {
                    $aData['Sex'] = config('settings.item.sex')[$aItem['ReqGender']];
                }
                if (isset(config('settings.item.cloth_type')[$aStats[1]][$aStats[3]])) {
                    $aData['Type'] = config('settings.item.cloth_type')[$aStats[1]][$aStats[3]];
                }
                if (isset(config('settings.item.cloth_detail')[$aStats[5]])) {
                    $aData['Detail'] = config('settings.item.cloth_detail')[$aStats[5]];
                }
                $aData['sox'] = self::getSOXRate4ItemClass($aItem['ItemClass'], $aItem['Rarity']);
                break;
        }

        $aData['Type'] = array_key_exists('Type', $aData) ? ucfirst(strtolower($aData['Type'])) : '';
        return $aData;
    }

    /**
     * @param $aRefData
     * @return bool
     */
    public function isPet($aRefData): bool
    {
        return $aRefData['TypeID2'] === 2 && $aRefData['TypeID3'] === 1;
    }

    /**
     * @param $iItemClass
     * @return float
     */
    protected static function getDegree4ItemClass($iItemClass): float
    {
        $iDegree = $iItemClass / 3;
        return ceil($iDegree);
    }

    /**
     * @param $iItemClass
     * @param $iRarity
     * @return mixed|string
     */
    protected static function getSOXRate4ItemClass($iItemClass, $iRarity)
    {
        if ($iRarity <= 1) {
            return '';
        }

        $iDegree = self::getDegree4ItemClass($iItemClass);
        $iSOXRate = (int)(($iDegree * 3) - $iItemClass);
        $iSOXRate = ($iDegree === 12 && $iSOXRate === 2) ? 3 : $iSOXRate;
        return config('settings.item.sox_type')[$iSOXRate];
    }

    /**
     * @param $iDifferenz
     * @return array
     */
    public static function diffTime($iDifferenz): array
    {
        $iDay = floor($iDifferenz / (3600 * 24));
        $iH = self::lengthCheck(floor($iDifferenz / 3600 % 24));
        $iM = self::lengthCheck(floor($iDifferenz / 60 % 60));
        $iS = self::lengthCheck(floor($iDifferenz % 60));

        return [
            'day' => $iDay,
            'hour' => $iH,
            'min' => $iM,
            's' => $iS,
        ];
    }

    /**
     * @param $iInteger
     * @return string
     */
    public static function lengthCheck($iInteger): string
    {
        return (strlen($iInteger) === 1) ? '0' . $iInteger : $iInteger;
    }

    /**
     * @param $CodeName128
     * @return mixed
     */

    /**
     * @param $aItem
     * @param $aSpecialInfo
     * @return array
     */
    protected function getBluesStats($aItem, &$aSpecialInfo): array
    {
        $_aMagOptLevel = MagOptDesc::getBlues($aItem,$aSpecialInfo);

        $aBlues = [];
        $aWheel = ($aItem['MagParam1'] >= 4611686018427387904) ? 2 : 1;

        for ($i = $aWheel; $i <= $aItem['MagParamNum']; $i++) {
            if (isset($aItem['MagParam' . $i]) && $aItem['MagParam' . $i] > 1) {
                $aData = self::convertBlue($aItem['MagParam' . $i], $_aMagOptLevel, $aSpecialInfo);
                if ($aData) {
                    $aBlues[] = $aData;
                }
            }
        }

        $bBlues = [];
        $counter = [];
        foreach ($aBlues as $aBlue) {
            if (!isset($counter[$aBlue['sortkey']])) {
                $counter[$aBlue['sortkey']] = 0;
                $sortkey = $aBlue['sortkey'];
            } else {
                $counter[$aBlue['sortkey']]++;
                $sortkey = $aBlue['sortkey'] . '_' . $counter[$aBlue['sortkey']];
            }

            $bBlues[$sortkey] = $aBlue;
        }

        ksort($bBlues);
        return $bBlues;
    }

    /**
     * @param $iMagParam
     * @param $_aMagOptLevel
     * @param $aSpecialInfo
     * @return array
     */
    protected static function convertBlue($iMagParam, $_aMagOptLevel, &$aSpecialInfo): array
    {
        if ($iMagParam === 65) {
            $aSpecialInfo['MATTR_DUR'] = (isset($aSpecialInfo['MATTR_DUR'])) ? ($aSpecialInfo['MATTR_DUR'] + 400) : 400;
            return [
                'name' => 'Repair invalid (Maximum durability 400% increase)',
                'color' => 'ff2f51',
                'sortkey' => 0,
                'extension' => '',
                'id' => 0
            ];
        }
        $hMagParam = (string)dechex($iMagParam);
        $aString = str_split($hMagParam);
        if (($iNumber = count($aString)) < 11) {
            $iNumber++;
            for ($i = $iNumber; $i <= 11; $i++) {
                array_unshift($aString, 0);
            }
        }
        $i = $aString[0] . $aString[1] . $aString[2];
        $aData = str_split($i);

        for ($i = 0; $i <= 5; $i++) {
            unset($aString[$i]);
        }

        $iState = hexdec(implode('', $aString));
        if (!isset($_aMagOptLevel[$iState])) {
            return [

            ];
        }

        // Durability Fix for 160%
        if ($_aMagOptLevel[$iState]['name'] === 'MATTR_DUR') {
            $iValue = implode('', $aData);
        } else {
            $iValue = implode('', $aData);
        }

        $iValue = hexdec($iValue);
        if ($_aMagOptLevel[$iState]['name'] === 'MATTR_REPAIR') {
            $iValue--;
        }
        $aSpecialInfo[$_aMagOptLevel[$iState]['name']] = (isset($aSpecialInfo[$_aMagOptLevel[$iState]['name']])) ? ($aSpecialInfo[$_aMagOptLevel[$iState]['name']] + $iValue) : $iValue;

        $cBlues =  [
            'id' => $iState,
            'code' => $_aMagOptLevel[$iState]['name'],
            'name' => str_replace('%desc%', $iValue, $_aMagOptLevel[$iState]['desc']),
            'color' => $_aMagOptLevel[$iState]['name'] === 'MATTR_DEC_MAXDUR' ? 'ff2f51' : '50cecd',
            'mValue' => $iValue,
            'mLevel' => $_aMagOptLevel[$iState]['mLevel'],
            'sortkey' => $_aMagOptLevel[$iState]['sortkey'],
        ];

        return $cBlues;
    }

    /**
     * @param $aItem
     * @param $aSpecialInfo
     * @return array
     */
    protected function getWhiteStats($aItem, $aSpecialInfo): array
    {
        if (!in_array($aItem['TypeID2'], [1, 4]) || in_array($aItem['TypeID3'], [7, 13, 14])) {
            return [];
        }
        $aWhiteStats = [];
        $iBinar = self::bin($aItem['Variance']);
        $aStats = strrev($iBinar);
        $aStats = str_split($aStats, 5);
        foreach ($aStats as $iBinar) {
            $iDezimal = bindec(strrev($iBinar));
            if ($iDezimal === 0) {
                $aWhiteStats[] = 0;
                continue;
            }
            $aWhiteStats[] = (int)($iDezimal * 100 / 31);
        }
        return self::convertToStats($aItem, $aWhiteStats, $aSpecialInfo);
    }

    /**
     * @param $int
     * @return string
     */
    protected static function bin($int): string
    {
        $i = 0;
        $binair = '';
        while ($int >= (2 ** $i)) {
            $i++;
        }

        if ($i !== 0) {
            --$i;
        }

        while ($i >= 0) {
            if ($int - (2 ** $i) < 0) {
                $binair = '0' . $binair;
            } else {
                $binair = '1' . $binair;
                $int -= (2 ** $i);
            }
            $i--;
        }
        return strrev($binair);
    }

    /**
     * @param $aItem
     * @param $aWhiteStats
     * @param $aSpecialInfo
     * @return array
     */
    protected static function convertToStats($aItem, $aWhiteStats, $aSpecialInfo): array
    {
        for ($i = 0; $i <= 6; $i++) {
            $aWhiteStats[$i] = $aWhiteStats[$i] ?? 0;
        }

        $aItem['nOptValue'] = $aItem['nOptValue'] ?? 0;

        if ($aItem['TypeID2'] == 1) {
            switch ($aItem['TypeID3']) {
                case self::WEAPON:
                    $aStats = [
                        0 => 'Phy. atk. pwr. ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['PAttackMin_L'],
                                    $aItem['PAttackMin_U'],
                                    $aWhiteStats[4]
                                ),
                                $aItem['PAttackInc'],
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) . ' ~ ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['PAttackMax_L'],
                                    $aItem['PAttackMax_U'],
                                    $aWhiteStats[4]
                                ),
                                $aItem['PAttackInc'],
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) . ' (+' . $aWhiteStats[4] . '%)',
                        1 => 'Mag. atk. pwr. ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['MAttackMin_L'],
                                    $aItem['MAttackMin_U'],
                                    $aWhiteStats[5]
                                ),
                                $aItem['MAttackInc'],
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) . ' ~ ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['MAttackMax_L'],
                                    $aItem['MAttackMax_U'],
                                    $aWhiteStats[5]
                                ),
                                $aItem['MAttackInc'],
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) . ' (+' . $aWhiteStats[5] . '%)',
                        2 => 'Durability ' . $aItem['Data'] . '/' . self::getDuraMaxValue(self::getValue(
                                $aItem['Dur_L'],
                                $aItem['Dur_U'],
                                $aWhiteStats[0]
                            ), $aSpecialInfo) . ' (+' . $aWhiteStats[0] . '%)',
                        3 => 'Attack rating ' . self::calcOPTValue(
                                self::getBlueValue(
                                    self::getValue(
                                        $aItem['HR_L'],
                                        $aItem['HR_U'],
                                        $aWhiteStats[3]
                                    ),
                                    $aSpecialInfo['MATTR_HR'] ?? 0
                                ),
                                $aItem['HRInc'],
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) . ' (+' . $aWhiteStats[3] . '%)',
                        4 => 'Critical ' . self::getValue(
                                $aItem['CHR_L'],
                                $aItem['CHR_U'],
                                $aWhiteStats[6]
                            ) . ' (+' . $aWhiteStats[6] . '%)',
                        5 => 'Phy. reinforce ' . self::getValue(
                                $aItem['PAStrMin_L'],
                                $aItem['PAStrMin_U'],
                                $aWhiteStats[1]
                            ) / 10 . ' % ~ ' . self::getValue(
                                $aItem['PAStrMax_L'],
                                $aItem['PAStrMax_U'],
                                $aWhiteStats[1]
                            ) / 10 . ' % (+' . $aWhiteStats[1] . '%)',
                        6 => 'Mag. reinforce ' . self::getValue(
                                $aItem['MAInt_Min_L'],
                                $aItem['MAInt_Min_U'],
                                $aWhiteStats[2]
                            ) / 10 . ' % ~ ' . self::getValue(
                                $aItem['MAInt_Max_L'],
                                $aItem['MAInt_Max_U'],
                                $aWhiteStats[2]
                            ) / 10 . ' % (+' . $aWhiteStats[2] . '%)'
                    ];
                    if ($aItem['PAttackMin_L'] === 0) {
                        unset($aStats[0], $aStats[5]);
                        $aStats[4] = 'Critical 2 (+100%)';
                    }
                    if ($aItem['MAttackMin_L'] === 0) {
                        unset($aStats[1], $aStats[6]);
                    }
                    break;
                case self::SHIELD:
                    $aStats = [
                        0 => 'Phy. def. pwr. ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['PD_L'] * 10,
                                    $aItem['PD_U'] * 10,
                                    $aWhiteStats[4]
                                ),
                                $aItem['PDInc'] * 10,
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) / 10 . ' (+' . $aWhiteStats[4] . '%)',
                        1 => 'Mag. def. pwr. ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['MD_L'] * 10,
                                    $aItem['MD_U'] * 10,
                                    $aWhiteStats[5]
                                ),
                                $aItem['MDInc'] * 10,
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) / 10 . ' (+' . $aWhiteStats[5] . '%)',
                        2 => 'Durability ' . $aItem['Data'] . '/' . self::getDuraMaxValue(self::getValue(
                                $aItem['Dur_L'],
                                $aItem['Dur_U'],
                                $aWhiteStats[0]
                            ), $aSpecialInfo) . ' (+' . $aWhiteStats[0] . '%)',
                        3 => 'Blocking rate ' . self::getValue(
                                $aItem['BR_L'],
                                $aItem['BR_U'],
                                $aWhiteStats[3]
                            ) . ' (+' . $aWhiteStats[3] . '%)',
                        4 => 'Phy. reinforce ' . self::getValue(
                                $aItem['PDStr_L'],
                                $aItem['PDStr_U'],
                                $aWhiteStats[1]
                            ) / 10 . ' % (+' . $aWhiteStats[1] . '%)',
                        5 => 'Mag. reinforce ' . self::getValue(
                                $aItem['MDInt_L'],
                                $aItem['MDInt_U'],
                                $aWhiteStats[2]
                            ) / 10 . ' % (+' . $aWhiteStats[2] . '%)'
                    ];
                    break;
                case 12:
                case self::ACC:
                    $aStats = [
                        0 => 'Phy. absorption ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['PAR_L'] * 10,
                                    $aItem['PAR_U'] * 10,
                                    $aWhiteStats[0]
                                ),
                                $aItem['PARInc'] * 10,
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) / 10 . ' (+' . $aWhiteStats[0] . '%)',
                        1 => 'Mag. absorption ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['MAR_L'] * 10,
                                    $aItem['MAR_U'] * 10,
                                    $aWhiteStats[1]
                                ),
                                $aItem['MARInc'] * 10,
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) / 10 . ' (+' . $aWhiteStats[1] . '%)'
                    ];
                    break;
                default:
                    $aStats = [
                        0 => 'Phy. def. pwr. ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['PD_L'] * 10,
                                    $aItem['PD_U'] * 10,
                                    $aWhiteStats[3]
                                ),
                                $aItem['PDInc'] * 10,
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) / 10 . ' (+' . $aWhiteStats[3] . '%)',
                        1 => 'Mag. def. pwr. ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['MD_L'] * 10,
                                    $aItem['MD_U'] * 10,
                                    $aWhiteStats[4]
                                ),
                                $aItem['MDInc'] * 10,
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) / 10 . ' (+' . $aWhiteStats[4] . '%)',
                        2 => 'Durability ' . $aItem['Data'] . '/' . self::getDuraMaxValue(self::getValue(
                                $aItem['Dur_L'],
                                $aItem['Dur_U'],
                                $aWhiteStats[0]
                            ), $aSpecialInfo) . ' (+' . $aWhiteStats[0] . '%)',
                        3 => 'Parry rate ' . self::calcOPTValue(
                                self::getBlueValue(
                                    self::getValue(
                                        $aItem['ER_L'],
                                        $aItem['ER_U'],
                                        $aWhiteStats[5]
                                    ),
                                    $aSpecialInfo['MATTR_ER'] ?? 0
                                ),
                                $aItem['ERInc'],
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) . ' (+' . $aWhiteStats[5] . '%)',
                        4 => 'Phy. reinforce ' . self::getValue(
                                $aItem['PDStr_L'],
                                $aItem['PDStr_U'],
                                $aWhiteStats[1]
                            ) / 10 . ' % (+' . $aWhiteStats[1] . '%)',
                        5 => 'Mag. reinforce ' . self::getValue(
                                $aItem['MDInt_L'],
                                $aItem['MDInt_U'],
                                $aWhiteStats[2]
                            ) / 10 . ' % (+' . $aWhiteStats[2] . '%)'
                    ];
                    break;
            }
        }elseif($aItem['TypeID2'] == 4) {
            switch ($aItem['TypeID3']) {
                case 1:
                    $aStats = [
                        0 => 'Phy. def. pwr. ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['PD_L'] * 10,
                                    $aItem['PD_U'] * 10,
                                    $aWhiteStats[4]
                                ),
                                $aItem['PDInc'] * 10,
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) / 10 . ' (+' . $aWhiteStats[4] . '%)',
                        1 => 'Mag. def. pwr. ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['MD_L'] * 10,
                                    $aItem['MD_U'] * 10,
                                    $aWhiteStats[5]
                                ),
                                $aItem['MDInc'] * 10,
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) / 10 . ' (+' . $aWhiteStats[5] . '%)',
                    ];
                    break;
                case 2:
                    $aStats = [
                        0 => 'Phy. atk. pwr. ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['PAttackMin_L'],
                                    $aItem['PAttackMin_U'],
                                    $aWhiteStats[4]
                                ),
                                $aItem['PAttackInc'],
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) . ' ~ ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['PAttackMax_L'],
                                    $aItem['PAttackMax_U'],
                                    $aWhiteStats[4]
                                ),
                                $aItem['PAttackInc'],
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) . ' (+' . $aWhiteStats[4] . '%)',
                        1 => 'Mag. atk. pwr. ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['MAttackMin_L'],
                                    $aItem['MAttackMin_U'],
                                    $aWhiteStats[5]
                                ),
                                $aItem['MAttackInc'],
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) . ' ~ ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['MAttackMax_L'],
                                    $aItem['MAttackMax_U'],
                                    $aWhiteStats[5]
                                ),
                                $aItem['MAttackInc'],
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) . ' (+' . $aWhiteStats[5] . '%)',
                    ];
                    break;
                case 3:
                    $aStats = [
                        0 => 'Phy. absorption ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['PAR_L'] * 10,
                                    $aItem['PAR_U'] * 10,
                                    $aWhiteStats[0]
                                ),
                                $aItem['PARInc'] * 10,
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) / 10 . ' (+' . $aWhiteStats[0] . '%)',
                        1 => 'Mag. absorption ' . self::calcOPTValue(
                                self::getValue(
                                    $aItem['MAR_L'] * 10,
                                    $aItem['MAR_U'] * 10,
                                    $aWhiteStats[1]
                                ),
                                $aItem['MARInc'] * 10,
                                ((int)$aItem['nOptValue'] + (int)$aItem['OptLevel'])
                            ) / 10 . ' (+' . $aWhiteStats[1] . '%)'
                    ];
                    break;
                default:

            }
        }
        return $aStats ?? [];
    }

    /**
     * @param $iValue
     * @param $iBonus
     * @param $iOptLvl
     * @return float
     */
    protected static function calcOPTValue($iValue, $iBonus, $iOptLvl): float
    {
        return round($iValue + $iBonus * $iOptLvl);
    }

    /**
     * @param $iMin
     * @param $iMax
     * @param $iProzent
     * @return float
     */
    protected static function getValue($iMin, $iMax, $iProzent): float
    {
        return round($iMin + ((($iMax - $iMin) / 100) * $iProzent));
    }

    /**
     * @param $iValue
     * @param $aSpecialInfo
     * @return float
     */
    protected static function getDuraMaxValue($iValue, $aSpecialInfo): float
    {
        if (isset($aSpecialInfo['MATTR_DUR'])) {
            $iValue = self::getBlueValue($iValue, $aSpecialInfo['MATTR_DUR']);
        }
        if (isset($aSpecialInfo['MATTR_DEC_MAXDUR'])) {
            $iValue = self::getBlueValueNegative($iValue, $aSpecialInfo['MATTR_DEC_MAXDUR']);
        }
        return $iValue;
    }

    /**
     * @param $iValue
     * @param $iProzent
     * @return float
     */
    protected static function getBlueValue($iValue, $iProzent): float
    {
        return round($iValue + (($iValue / 100) * $iProzent));
    }

    /**
     * @param $iValue
     * @param $iProzent
     * @return float
     */
    protected static function getBlueValueNegative($iValue, $iProzent): float
    {
        return round($iValue - ($iValue / 100 * $iProzent));
    }
}
