import * as React from 'react';
import CustomDatePicker from '../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import CustomSwitch from '../../../../../../../../../../../../../../components/CustomSwitch';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';

const Templates = () => (
  <div className="templates">
    <SectionWithTitle title="Договір">
      <div className="grid">
        <CustomSelect label="Тип договору" data={[]} onChange={(e) => console.log(e)} />
        <CustomSelect label="Шаблон договору" data={[]} onChange={(e) => console.log(e)} />
        <CustomDatePicker label="Дата підписання договору" onSelect={(e) => console.log(e)} />
        <CustomSwitch label="Оброблений" onChange={(e) => console.log(e)} selected={false} />
        <CustomDatePicker label="ПД - дата підписання ОД" onSelect={(e) => console.log(e)} />
      </div>
    </SectionWithTitle>

    <SectionWithTitle title="Оплата рахунку">
      <div className="flex-center">
        <CustomSelect label="Шаблон рахунку" data={[]} onChange={(e) => console.log(e)} className="single" />
      </div>
    </SectionWithTitle>

    <SectionWithTitle title="Оплата податків">
      <div className="flex-center">
        <CustomSelect label="Шаблон рахунку податків" data={[]} onChange={(e) => console.log(e)} className="single" />
      </div>
    </SectionWithTitle>

    <SectionWithTitle title="Запит">
      <div className="grid-center-duet">
        <CustomSelect label="Шаблон запиту" data={[]} onChange={(e) => console.log(e)} />
        <CustomDatePicker label="Дата підписання запиту" onSelect={(e) => console.log(e)} />
      </div>
    </SectionWithTitle>

    <SectionWithTitle title="Анкета">
      <div className="grid-center-duet">
        <CustomSelect label="Шаблон анкети" data={[]} onChange={(e) => console.log(e)} />
        <CustomDatePicker label="Дата підписання анкети" onSelect={(e) => console.log(e)} />
      </div>
    </SectionWithTitle>

    <div className="middle-button">
      <PrimaryButton label="Зберегти" onClick={() => console.log('click')} disabled={false} />
    </div>
  </div>
);

export default Templates;
