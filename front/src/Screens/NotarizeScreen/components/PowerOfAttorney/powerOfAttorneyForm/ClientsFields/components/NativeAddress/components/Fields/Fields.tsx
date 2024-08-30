import * as React from 'react';

import AddFormButton from '../../../../../../../../../../components/AddFormButton';
import CustomInput from '../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../components/CustomSelect';
import { SelectItem } from '../../../../../../../../../../types';

type Props = {
  regions: SelectItem[],
  cities: SelectItem[],
  districts: SelectItem[],
  addressType: SelectItem[],
  apartmentType: SelectItem[],
  buildingType: SelectItem[],
  buildingPartType: SelectItem[],
  data: any,
  onRegionChange: (value: string) => void,
  onDistrictChange: (value: string) => void,
  setData: (data: any) => void,
  setShowModal: (val: boolean) => void,
  actual?: boolean,
}

const Fields = ({
  regions,
  cities,
  districts,
  addressType,
  buildingType,
  buildingPartType,
  apartmentType,
  data,
  actual,
  onRegionChange,
  onDistrictChange,
  setData,
  setShowModal
}: Props) => (
  <div className="address__container">
    <div className="clients__address-container">
      <CustomSelect
        disableDefaultValue
        label="Область"
        data={regions}
        onChange={(e) => onRegionChange(e)}
        selectedValue={data.native_region_id}
      />
    </div>

    <div className="clients__address-container">
      <CustomSelect
        label="Район"
        data={districts}
        onChange={(e) => onDistrictChange(e)}
        selectedValue={data.native_district_id}
      />
    </div>

    <div className="clients__address-container df">
      <CustomSelect
        label="Населений пункт"
        data={cities}
        onChange={(e) => setData({ ...data, [`${actual ? 'actual_city_id' : 'native_city_id'}`]: e })}
        selectedValue={data.native_city_id}
      />
      <div className="add-button">
        <AddFormButton onClick={() => setShowModal(true)} />
      </div>
    </div>
  </div>
);

export default Fields;
