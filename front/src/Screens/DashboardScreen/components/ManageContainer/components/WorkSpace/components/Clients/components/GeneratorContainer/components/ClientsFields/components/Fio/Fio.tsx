import * as React from 'react';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';

const Fio = () => (
  <div className="clients__fio">
    <div className="clients__fio-header">
      <span className="section-title">ПІБ</span>
      <button type="button" className="clear-button">
        <img
          src="/icons/clear-form.svg"
          alt="close"
          className="clear-icon"
          onClick={() => console.log('clear')}
        />
      </button>
    </div>

    <SectionWithTitle title="Називний відмінок">
      <div className="grid">
        <CustomInput
          label="Прізвище"
          onChange={(e) => console.log(e)}
          value="Киселев"
        />

        <CustomInput
          label="Ім'я"
          onChange={(e) => console.log(e)}
          value="Киселев"
        />

        <CustomInput
          label="По батькові"
          onChange={(e) => console.log(e)}
          value="Киселев"
        />
      </div>
    </SectionWithTitle>

    <SectionWithTitle title="Родовий відмінок">
      <div className="grid">
        <CustomInput
          label="Прізвище"
          onChange={(e) => console.log(e)}
          value="Киселев"
        />

        <CustomInput
          label="Ім'я"
          onChange={(e) => console.log(e)}
          value="Киселев"
        />

        <CustomInput
          label="По батькові"
          onChange={(e) => console.log(e)}
          value="Киселев"
        />
      </div>
    </SectionWithTitle>

    <SectionWithTitle title="Орудний відмінок">
      <div className="grid">
        <CustomInput
          label="Прізвище"
          onChange={(e) => console.log(e)}
          value="Киселев"
        />

        <CustomInput
          label="Ім'я"
          onChange={(e) => console.log(e)}
          value="Киселев"
        />

        <CustomInput
          label="По батькові"
          onChange={(e) => console.log(e)}
          value="Киселев"
        />
      </div>
    </SectionWithTitle>

    <div className="middle-button">
      <PrimaryButton label="Зберегти" onClick={() => console.log('click')} disabled={false} />
    </div>
  </div>
);

export default Fio;
