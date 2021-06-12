import * as React from 'react';
import AddFormButton from '../../../../../../../../../../../../../../../../components/AddFormButton';
import CustomInput from '../../../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../../../components/CustomSelect';
import { SelectItem } from '../../../../../../../../../../../../../../../../types';

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
        selectedValue={actual ? data.actual_region_id : data.region_id}
      />
    </div>

    <div className="clients__address-container">
      <CustomSelect
        label="Район"
        data={districts}
        onChange={(e) => onDistrictChange(e)}
        selectedValue={actual ? data.actual_district_id : data.district_id}
      />
    </div>

    <div className="clients__address-container df">
      <CustomSelect
        label="Населений пункт"
        data={cities}
        onChange={(e) => setData({ ...data, [`${actual ? 'actual_city_id' : 'city_id'}`]: e })}
        selectedValue={actual ? data.actual_city_id : data.city_id}
      />
      <div className="add-button">
        <AddFormButton onClick={() => setShowModal(true)} />
      </div>
    </div>

    <div className="clients__address-container df duet">
      <div className="short-width">
        <CustomSelect
          label="Тип вулиці"
          data={addressType}
          onChange={(e) => setData({ ...data, [`${actual ? 'actual_address_type_id' : 'address_type_id'}`]: e })}
          selectedValue={actual ? data.actual_address_type_id : data.address_type_id}
        />
      </div>
      <div className="long-width">
        <CustomInput
          label="Назва вулиці"
          onChange={(e) => setData({ ...data, [`${actual ? 'actual_address' : 'address'}`]: e })}
          value={actual ? data.actual_address : data.address}
        />
      </div>
    </div>

    <div className="clients__address-container df duet">
      <div className="long-width">
        <CustomSelect
          label="Тип будинку"
          data={buildingType}
          onChange={(e) => setData({ ...data, [`${actual ? 'actual_building_type_id' : 'building_type_id'}`]: e })}
          selectedValue={actual ? data.actual_building_type_id : data.building_type_id}
        />
      </div>
      <div className="short-width">
        <CustomInput
          label="Номер будинку"
          onChange={(e) => setData({ ...data, [`${actual ? 'actual_building_num' : 'building_num'}`]: e })}
          value={actual ? data.actual_building_num : data.building_num}
        />
      </div>
    </div>

    <div className="clients__address-container df duet">
      <div className="long-width">
        <CustomSelect
          label="Частина будівлі"
          data={buildingPartType}
          onChange={(e) => setData({ ...data, [`${actual ? 'actual_building_part_id' : 'building_part_id'}`]: e })}
          selectedValue={actual ? data.actual_building_part_id : data.building_part_id}
        />
      </div>
      <div className="short-width">
        <CustomInput
          label="Номер"
          onChange={(e) => setData({ ...data, [`${actual ? 'actual_building_part_num' : 'building_part_num'}`]: e })}
          value={actual ? data.actual_building_part_num : data.building_part_num}
        />
      </div>
    </div>

    <div className="clients__address-container df duet">
      <div className="long-width">
        <CustomSelect
          label="Тип приміщення"
          data={apartmentType}
          onChange={(e) => setData({ ...data, [`${actual ? 'actual_apartment_type_id' : 'apartment_type_id'}`]: e })}
          selectedValue={actual ? data.actual_apartment_type_id : data.apartment_type_id}
        />
      </div>
      <div className="short-width">
        <CustomInput
          label="Номер приміщення"
          onChange={(e) => setData({ ...data, [`${actual ? 'actual_apartment_num' : 'apartment_num'}`]: e })}
          value={actual ? data.actual_apartment_num : data.apartment_num}
        />
      </div>
    </div>
  </div>
);

export default Fields;
