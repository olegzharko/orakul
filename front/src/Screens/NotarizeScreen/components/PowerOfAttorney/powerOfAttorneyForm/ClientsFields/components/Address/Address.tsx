import React from 'react';

import CustomSwitch from '../../../../../../../../components/CustomSwitch';
import PrimaryButton from '../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../components/SectionWithTitle';

import AddCityModal from './components/AddCityModal';
import Fields from './components/Fields';
import { useAddress, Props } from './useAddress';

const Address = (props: Props) => {
  const meta = useAddress(props);

  return (
    <div className="clients__address">
      <SectionWithTitle title="Адреса" onClear={meta.onClear} headerColor={props?.headerColor}>
        <div className="grid-center-duet mb20">
          <div className="clients__address-container">
            <CustomSwitch
              label="Зареєстрований"
              onChange={(e) => meta.setRegistration(e)}
              selected={meta.registration}
            />
          </div>

          <div className="clients__address-container">
            <CustomSwitch
              label="Актуальне місце проживання"
              onChange={(e) => meta.setActual(e)}
              selected={meta.actual}
            />
          </div>
        </div>
        <div className={`clients__address-fields ${meta.actual ? 'double' : ''}`}>
          <Fields
            regions={meta.regions}
            cities={meta.cities}
            districts={meta.districts}
            addressType={meta.addressType}
            buildingType={meta.buildingType}
            buildingPartType={meta.buildingPartType}
            apartmentType={meta.apartmentType}
            data={meta.data}
            onRegionChange={meta.onRegionChange}
            onDistrictChange={meta.onDistrictChange}
            setData={meta.setData}
            setShowModal={meta.setShowModal}
          />

          {meta.actual && (
            <Fields
              actual
              regions={meta.actualRegions}
              cities={meta.actualCities}
              districts={meta.actualDistricts}
              addressType={meta.addressType}
              buildingType={meta.buildingType}
              buildingPartType={meta.buildingPartType}
              apartmentType={meta.apartmentType}
              data={meta.actualData}
              onRegionChange={meta.onActualRegionChange}
              onDistrictChange={meta.onActualDistrictChange}
              setData={meta.setActualData}
              setShowModal={meta.setShowModal}
            />
          )}
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={false} />
      </div>

      <AddCityModal open={meta.showModal} onClose={meta.setShowModal} />
    </div>
  );
};

export default Address;
