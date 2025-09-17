import { ScrollView, View, Text, Image, TouchableOpacity, StyleSheet, StatusBar } from 'react-native';
import React from 'react';
import { useRouter } from 'expo-router';
import { AntDesign } from '@expo/vector-icons';
import { FontAwesome5 } from '@expo/vector-icons'; // Masih dibutuhkan jika ada ikon lain dari FontAwesome5
import { MaterialIcons } from '@expo/vector-icons';
import { useSafeAreaInsets } from 'react-native-safe-area-context';


import { useEffect, useState } from 'react';
import { API_URL } from '../api/config';


const Homepage: React.FC = () => {
  const router = useRouter();
  const insets = useSafeAreaInsets();
  const [educations, setEducations] = useState<any[]>([]);
  useEffect(() => {
    fetch(`${API_URL}/jenis-bencana`)
      .then(res => res.json())
      .then(json => setEducations(Array.isArray(json.data) ? json.data : []));
  }, []);

  const handleReportPress = () => {
    router.push('/LaporBencana');
  };

  const handleEducationListPress = (name?: string) => {
    if (name) {
      router.push({ pathname: '/(tabs)/ListEdukasiByJenis', params: { jenis: name } });
    } else {
      router.push('/EdukasiBencana');
    }
  };

  const handlePenyuluhanPress = () => {
    router.push('/PenyuluhanScreen');
  };

  const handleProfilePress = () => {
    router.push('/Profile');
  };

  return (
    <View style={styles.container}>
      <StatusBar barStyle="light-content" backgroundColor="#D48442" />

      {/* Header Utama */}
      <View style={[styles.header, { paddingTop: insets.top + 10 }]}>
        {/* Slot Kiri (Kosong atau untuk ikon menu/dll) */}
        <View style={styles.headerLeft}>
          {/* Tidak ada tombol kembali di Homepage */}
        </View>

        {/* Slot Tengah (Judul Homepage) */}
        <View style={styles.headerCenter}>
          <Text style={styles.headerText}>Homepage</Text>
        </View>

        {/* Slot Kanan (Hanya Ikon Profil sekarang) */}
        <View style={styles.headerRight}>
          <TouchableOpacity onPress={() => router.push('/HistoryLaporan')} style={styles.headerIcon}>
            <MaterialIcons name="history" size={26} color="white" />
          </TouchableOpacity>
          <TouchableOpacity onPress={handleProfilePress} style={styles.headerIcon}>
            <MaterialIcons name="person" size={26} color="white" />
          </TouchableOpacity>
        </View>
      </View>

      {/* Konten Utama yang bisa di-scroll */}
      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        {/* Tombol Lapor di Tengah */}
        <View style={styles.laporSection}>
          <Text style={styles.laporSectionTitle}>Laporkan Bencana</Text>
          <Text style={styles.laporSectionSubtitle}>Segera laporkan kejadian darurat</Text>
          <TouchableOpacity style={styles.laporButton} onPress={handleReportPress}>
            <Text style={styles.laporText}>Lapor Sekarang</Text>
          </TouchableOpacity>
        </View>

        {/* Tombol Edukasi */}
        <TouchableOpacity style={styles.educationButton} onPress={() => handleEducationListPress()}>
          <Text style={styles.educationButtonText}>Cari Edukasi Bencana Lainnya</Text>
          <AntDesign name="arrowright" size={18} color="#D48442" />
        </TouchableOpacity>

        {/* --- TOMBOL PENYULUHAN BARU DI SINI --- */}
        <TouchableOpacity style={styles.penyuluhanButton} onPress={handlePenyuluhanPress}>
          <Text style={styles.penyuluhanButtonText}>Informasi Penyuluhan</Text>
          <FontAwesome5 name="chalkboard-teacher" size={18} color="#66320F" /> {/* Ikon Penyuluhan */}
        </TouchableOpacity>
        {/* --- AKHIR TOMBOL PENYULUHAN BARU --- */}

        {/* List Bencana Horizontal */}
        <View style={styles.horizontalListSection}>
          <Text style={styles.horizontalListTitle}>Jelajahi Jenis Bencana</Text>
          <ScrollView horizontal showsHorizontalScrollIndicator={false} contentContainerStyle={styles.horizontalScroll}>
            {educations.map((item) => (
              <TouchableOpacity
                key={item.id}
                style={styles.horizontalItemCard}
                onPress={() => handleEducationListPress(item.nama_jenis)}>
                <Image source={require('@/assets/images/Banjir.png')} style={styles.horizontalItemImage} />
                <Text style={styles.horizontalItemLabel}>{item.nama_jenis}</Text>
              </TouchableOpacity>
            ))}
          </ScrollView>
        </View>
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#FFF8F0',
  },
  header: {
    width: '100%',
    backgroundColor: '#D48442',
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingHorizontal: 16,
    paddingBottom: 16,
    borderBottomLeftRadius: 20,
    borderBottomRightRadius: 20,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.2,
    shadowRadius: 5,
    elevation: 8,
  },
  headerLeft: {
    flex: 1,
    alignItems: 'flex-start',
  },
  headerCenter: {
    flex: 2,
    alignItems: 'center',
    justifyContent: 'center',
  },
  headerRight: {
    flex: 1,
    flexDirection: 'row',
    justifyContent: 'flex-end',
    alignItems: 'center',
  },
  headerIcon: {
    marginLeft: 15,
  },
  headerText: {
    color: 'white',
    fontWeight: 'bold',
    fontSize: 20,
    textAlign: 'center',
  },
  scrollContent: {
    flexGrow: 1,
    paddingVertical: 20,
    paddingHorizontal: 16,
  },
  laporSection: {
    alignItems: 'center',
    marginBottom: 30,
    paddingVertical: 20,
    backgroundColor: 'white',
    borderRadius: 15,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 3.84,
    elevation: 5,
  },
  laporSectionTitle: {
    fontSize: 22,
    fontWeight: 'bold',
    color: '#333',
    marginBottom: 5,
    textAlign: 'center',
  },
  laporSectionSubtitle: {
    fontSize: 14,
    color: '#777',
    marginBottom: 20,
    textAlign: 'center',
  },
  laporButton: {
    width: 160,
    height: 160,
    borderRadius: 80,
    backgroundColor: '#D2601A',
    justifyContent: 'center',
    alignItems: 'center',
    shadowColor: '#000',
    shadowOpacity: 0.3,
    shadowOffset: { width: 0, height: 6 },
    shadowRadius: 8,
    elevation: 10,
  },
  laporText: {
    color: 'white',
    fontWeight: 'bold',
    fontSize: 20,
    textAlign: 'center',
  },
  educationButton: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    backgroundColor: 'white',
    paddingVertical: 15,
    paddingHorizontal: 20,
    borderRadius: 15,
    marginBottom: 15, // Mengurangi margin bawah sedikit karena ada tombol baru di bawahnya
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowOffset: { width: 0, height: 2 },
    shadowRadius: 3.84,
    elevation: 5,
    borderWidth: 1,
    borderColor: '#D4844230',
  },
  educationButtonText: {
    color: '#D48442',
    fontWeight: 'bold',
    fontSize: 16,
  },
  // --- GAYA BARU UNTUK TOMBOL PENYULUHAN ---
  penyuluhanButton: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    backgroundColor: 'white',
    paddingVertical: 15,
    paddingHorizontal: 20,
    borderRadius: 15,
    marginBottom: 30, // Jarak ke elemen berikutnya (List Bencana)
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowOffset: { width: 0, height: 2 },
    shadowRadius: 3.84,
    elevation: 5,
    borderWidth: 1,
    borderColor: '#66320F30', // Warna border berbeda agar ada variasi
  },
  penyuluhanButtonText: {
    color: '#66320F', // Warna teks yang berbeda
    fontWeight: 'bold',
    fontSize: 16,
  },
  // --- AKHIR GAYA BARU ---
  horizontalListSection: {
    marginBottom: 20,
  },
  horizontalListTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#333',
    marginBottom: 15,
    textAlign: 'center',
  },
  horizontalScroll: {
    // paddingHorizontal: 5, // Sedikit padding untuk scroll
  },
  horizontalItemCard: {
    backgroundColor: 'white',
    borderRadius: 12,
    padding: 15,
    alignItems: 'center',
    justifyContent: 'center',
    marginRight: 15,
    width: 120,
    height: 120,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 3.84,
    elevation: 4,
    borderWidth: 1,
    borderColor: '#D4844220',
  },
  horizontalItemImage: {
    width: 50,
    height: 50,
    resizeMode: 'contain',
    marginBottom: 8,
  },
  horizontalItemLabel: {
    fontSize: 12,
    textAlign: 'center',
    color: '#333',
    fontWeight: 'bold',
  },
});

export default Homepage;